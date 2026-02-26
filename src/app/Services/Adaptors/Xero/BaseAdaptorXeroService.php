<?php

namespace App\Services\Adaptors\Xero;

use App\Enums\IntegrationsType;
use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Services\Adaptors\BaseDataExporterService;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class BaseAdaptorXeroService extends BaseDataExporterService
{
    protected string $endpoint = "/";
    protected string $endpoint_ext = "";
    protected string $tag = "";
    protected $resourceClass;
    protected $syncType = ThirdPartySyncProcessTypeEnum::CREATE;
    protected $objectName;
    protected $objectIDName;
    protected int $perBatch = 50; // max batch size

    abstract function getData($object_id): \Illuminate\Database\Eloquent\Collection|array;

    public function getType(): string
    {
        return IntegrationsType::Xero->value;
    }

    public function export($object_id=null): void
    {
        $items = $this->getData($object_id);

        if (!$items || count($items) === 0) return;
        if ($this->syncType !== ThirdPartySyncProcessTypeEnum::CREATE || count($items) < $this->perBatch) {
            foreach ($items as $item) {
                $this->syncObject($item);
            }
        } else {
            $this->syncBatch($items);
        }
    }

    public function syncObject($objectData, int $try_no = 0): void
    {
        try {
            $objectData['thirdPartyAccess'] = $this->thirdPartyAccess;
            if($this->syncType != ThirdPartySyncProcessTypeEnum::DELETE)
                $data = (new $this->resourceClass($objectData))->toArray(request());
//            dd($data);


            if ($this->syncType === ThirdPartySyncProcessTypeEnum::CREATE) {
                $response = $this->sendRequest('post', [$this->objectName => [$data]]);
            } elseif ($this->syncType === ThirdPartySyncProcessTypeEnum::UPDATE) {
                $thirdPartyId = $objectData->xeroMapping?->third_party_id;
                if (!$thirdPartyId) {
                    throw new Exception("No Xero ID found for update.");
                }
                $response = $this->sendRequest('post', [$this->objectName => [$data]], "{$this->endpoint}/{$thirdPartyId}");
            } elseif ($this->syncType === ThirdPartySyncProcessTypeEnum::DELETE) {
                $thirdPartyId = $objectData->xeroMapping?->third_party_id;
                if (!$thirdPartyId) {
                    throw new Exception("No Xero ID found for deletion.");
                }
                $response = $this->sendRequest('delete', [], "{$this->endpoint}/{$thirdPartyId}");
            } elseif ($this->syncType === ThirdPartySyncProcessTypeEnum::VOID) {
                $thirdPartyId = $objectData->xeroMapping?->third_party_id;
                if (!$thirdPartyId) {
                    throw new Exception("No Xero ID found for deletion.");
                }
                $response = $this->sendRequest('post', [$this->objectName => [$data]], "{$this->endpoint}/{$thirdPartyId}");
            } else {
                throw new Exception("Unsupported syncType: " . $this->syncType);
            }


            $result = $response->json();
            $this->handleSyncSuccess($objectData, $result[$this->objectName][0][$this->objectIDName] ?? null,$result[$this->objectName][0]["Code"] ?? null);

        } catch (\Throwable $e) {
            if ($this->isUnauthorizedError($e) && $try_no === 1) {
                Log::info("Token expired, refreshing and retrying once...");

                // refresh Xero token
                $this->authenticate();

                // retry once after refreshing
                $this->syncObject($objectData, $try_no + 1);
            }
            $this->handleSyncObjectError($objectData, $e, $try_no);
        }
    }
    protected function sendRequest(string $method, array $payload = [], ?string $endpoint = null)
    {
        $url = $endpoint ?? $this->endpoint;
        $url = "{$url}/{$this->endpoint_ext}";
        if($this->tag=='Allocated')
            $method='put';
//        dd($url, $method, $payload);
        $response = Http::withHeaders([
            'Authorization' => "Bearer " . $this->thirdPartyAccess->access_token,
            'Xero-tenant-id' => $this->thirdPartyAccess->organization?->third_party_id,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->{$method}($url, $payload);
//dd($response,$url, $payload,$method);
        if (!$response->successful()) {
            throw new Exception($response->body());
        }

        return $response;
    }
    public function syncBatch($items, int $try_no = 1): void
    {
//        dump('in sync batch try no: ' . $try_no);
        $totalItems = $items->count();
//        dump('in sync batch items: ' . $totalItems);
        foreach ($items->chunk($this->perBatch) as $chunkIndex => $chunk) {
            $remainingItems = $totalItems - ($chunkIndex * $this->perBatch);
//            dump("Processing chunk " . ($chunkIndex + 1) . ", remaining items: " . $remainingItems);

            try {
                $batchData = [];
                foreach ($chunk as $item) {
                    $item['thirdPartyAccess'] = $this->thirdPartyAccess;
                    $batchData[] = (new $this->resourceClass($item))->toArray(request());
                }

                $response = Http::withHeaders([
                    'Authorization' => "Bearer " . $this->thirdPartyAccess->access_token,
                    'Xero-tenant-id' => $this->thirdPartyAccess->organization?->third_party_id,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post($this->endpoint, [$this->objectName => $batchData]);

                if (!$response->successful()) {
                    throw new Exception($response->body());
                }

                $result = $response->json();
                $index=0;
                foreach ($chunk as $item) {
                    Log::info($index);
                    $this->handleSyncSuccess($item, $result[$this->objectName][$index][$this->objectIDName],$result[$this->objectName][0]["Code"] ?? null);
                    $index++;
                }

            } catch (\Throwable $e) {
                if ($this->isUnauthorizedError($e) && $try_no === 1) {
                    Log::info("Token expired, refreshing and retrying once...");

                    // refresh Xero token
                    $this->authenticate();

                    // retry once after refreshing
                    $this->syncBatch($chunk, $try_no + 1);
                }
//                dump('handling error... try_no: ' . $try_no);
                $this->handleBatchError($chunk->all(), $e, $try_no);
            }
        }
    }
    protected function isUnauthorizedError(\Throwable $e): bool
    {
        if (method_exists($e, 'getResponse') && $e->getResponse()) {
            return in_array(
                $e->getResponse()->getStatusCode(),
                [401, 403]
            );
        }
        $body = json_decode($e->getMessage(), true);
        if (is_array($body) && isset($body['Status'])) {
            return in_array($body['Status'], [401, 403]);
        }
        return false;
    }
    protected function handleSyncSuccess($model, $thirdPartyId,$code): void
    {
        if ($this->syncType === ThirdPartySyncProcessTypeEnum::UPDATE) {
            $model->xeroMapping->update([
                'third_party_tag' => $this->tag,
                'updated_at' => now()
            ]);
        } elseif ($this->syncType === ThirdPartySyncProcessTypeEnum::CREATE) {
            $this->saveToMapping(
                object: $model,
                thirdPartyId: $thirdPartyId,
                type: $this->getType(),
                thirdPartyCode: $code,
                merchant_id: $this->thirdPartyAccess?->merchant_id,
                tag: $this->tag
            );
        }
        elseif($this->syncType === ThirdPartySyncProcessTypeEnum::DELETE) {
            $model->xeroMapping?->delete();
        }
        elseif($this->syncType === ThirdPartySyncProcessTypeEnum::VOID) {
            $model->xeroMapping?->delete();
        }
//        dump(get_class($model) . " " . ($model->index ?? $model->id ?? 'n/a') . " Synced To Xero Successfully");
    }

    protected function handleSyncObjectError($objectData, \Throwable $e, int $try_no): void
    {
        $message = $e->getMessage();
        $decoded = json_decode($message, true);
        if (json_last_error() === JSON_ERROR_NONE && isset($decoded['Elements'])) {
            $errors = [];

            foreach ($decoded['Elements'] as $element) {
                // Invoice-level errors
                if (!empty($element['ValidationErrors'])) {
                    foreach ($element['ValidationErrors'] as $err) {
                        $errors[] = $err['Message'];
                    }
                }
            }
            $message = implode(" | ", $errors);
        }
//        dump(get_class($objectData) . " " . ($objectData->index ?? $objectData->id ?? 'n/a') . " Failed to sync: " . $message . " ,Try no." . $try_no);

        if ($try_no < 2) {
            $this->syncObject($objectData, $try_no + 1);
        } else {
//            dump('saving to fail');
            $this->saveToFailedSync($objectData, $this->getType(), $message,$this->syncIntegrationId,$this->thirdPartyAccess->merchant_id);
        }
    }

    protected function handleBatchError(array $chunk, \Throwable $e, int $try_no): void
    {
        $message = $e->getMessage();
        $decoded = json_decode($message, true);

        $failedItems = [];
        $errorsMap = [];

        if (json_last_error() === JSON_ERROR_NONE && isset($decoded['Elements'])) {
            foreach ($decoded['Elements'] as $element) {
                // If element has errors
                if (!empty($element['ValidationErrors'])) {
                    $itemCode = $element['Reference'] ?? $element['InvoiceNumber'] ?? "Unknown";
                    foreach ($element['ValidationErrors'] as $err) {
                        $errorsMap[$itemCode][] = $err['Message'];
                    }
                }
            }
        }

//        dump("Batch failed (try_no {$try_no}) -> " . json_encode($errorsMap));
        $resync_obj=0;
        // Separate success candidates from failed ones
        foreach ($chunk as $model) {
//            dump($resync_obj++);
            $this->syncObject($model, $try_no + 1);
        }


    }

}
