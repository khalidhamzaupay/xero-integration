<?php

namespace App\Jobs;

use App\Enums\SyncIntegrationStatusEnum;
use App\Models\Integrations\SyncIntegration;
use App\Models\Integrations\ThirdPartyAccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Exception;
use Illuminate\Support\Facades\Log;

class ExporterAdaptorServiceJob implements ShouldQueue
{
    use Queueable;

    protected string            $adaptorClass;
    protected ?ThirdPartyAccess $thirdPartyAccess;
    protected ?SyncIntegration  $syncIntegration;
    /**
     * Create a new job instance.
     */
    public function __construct(string $adaptorClass, ThirdPartyAccess|null $thirdPartyAccess, SyncIntegration|null $syncIntegration)
    {
        $this->adaptorClass      = $adaptorClass;
        $this->thirdPartyAccess  = $thirdPartyAccess;
        $this->syncIntegration = $syncIntegration;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        dump('job for adaptor class: '.$this->adaptorClass);
        try{
            (new $this->adaptorClass($this->thirdPartyAccess,$this->syncIntegration?->id))->export();
            if($this->syncIntegration){
                SyncIntegration::update(
                    [
                        'end_at' => now(),
                        'status' => SyncIntegrationStatusEnum::SUCCESS->value,
                    ]);
            }
        }catch(Exception $e){
            Log::error(self::class.": ".$e->getMessage());
            if($this->syncIntegration){
                SyncIntegration::update(
                    [
                        'end_at' => now(),
                        'status' => SyncIntegrationStatusEnum::FAIL->value,
                    ]);
            }
        }
    }
}
