<?php


namespace App\Services\Adaptors\Get;


use App\Http\Resources\Xero\XeroImportTaxResource;
use App\Models\Integrations\ThirdPartyAccess;
use App\Models\Integrations\ThirdPartyTax;
use App\Services\ThirdPartyAccess\Authentication\XeroAuthentication;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetThirdPartyTaxesAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/TaxRates";
    protected $objectsName = 'TaxRates';
    protected $objectIDName = 'TaxType';
    protected $resourceClass = XeroImportTaxResource::class;
    protected $token;
    protected XeroAuthentication $xeroAuthentication;

    public function __construct(public ThirdPartyAccess $thirdPartyAccess)
    {
        $this->xeroAuthentication = new XeroAuthentication();
        try {
            $this->token = $this->thirdPartyAccess->access_token;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function import(): array
    {
        $items = [];
        $itemsData = $this->getObjectsAPIRequest()[$this->objectsName] ?? [];

        foreach ($itemsData as $itemData) {
            $data = (new $this->resourceClass($itemData))->toArray(request());
            $data['third_party_access_id'] = $this->thirdPartyAccess?->id;
            $data['merchant_id'] = $this->thirdPartyAccess?->merchant_id;

            $items[] = ThirdPartyTax::updateOrCreate(
                Arr::only($data, 'mapping_id'),
                Arr::except($data, 'mapping_id')
            );
        }

        return $items;
    }

    private function getObjectsAPIRequest()
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer " . $this->thirdPartyAccess->access_token,
            'xero-tenant-id' => $this->thirdPartyAccess->organization?->third_party_id,
        ])->get($this->endpoint);

        if (!$response->successful()) {
            $this->thirdPartyAccess->access_token = $this->xeroAuthentication->getAccessToken($this->thirdPartyAccess);
            $this->thirdPartyAccess->save();
            return $this->getObjectsAPIRequest();
        }

        return $response->json();
    }
}
