<?php

namespace App\Services\SyncIntegration;


use App\Enums\SyncIntegrationStatusEnum;
use App\Jobs\ExporterAdaptorServiceJob;
use App\Models\Integrations\SyncIntegration;
use App\Models\Integrations\ThirdPartyAccess;
use Illuminate\Support\Facades\Bus;

class IntegrationExportDataService
{
    protected $thirdPartsAccess;
    protected $type;

    public function __construct($thirdPartsAccessId)
    {
        $this->thirdPartsAccess= ThirdPartyAccess::find($thirdPartsAccessId);
        $this->type = $this->thirdPartsAccess->type;
    }


    public function export(): array
    {
        $syncIntegration = SyncIntegration::create(['merchant_id' => $this->thirdPartsAccess->merchant_id, 'method' => 'all', 'type' => $this->type]);
        $jobs = $this->getSyncExportJobsList($syncIntegration);
        Bus::chain($jobs)
            ->catch(function (\Throwable $e) use ($syncIntegration) {
                $syncIntegration->update(['end_at' => now(), 'status' => SyncIntegrationStatusEnum::FAIL->value]);
                logger()->error($this->type." export failed for {$this->thirdPartsAccess->id}: " . $e->getMessage());
            })
            ->onQueue('export-integrations')
            ->dispatch();
        return $syncIntegration;
    }

    public function getSyncExportJobsList($syncIntegration):?array
    {
        $jobs=[];
        foreach (config('integrationAdaptors.'.$this->type.'.export') as $class){
            $jobs[]=new ExporterAdaptorServiceJob($class, $this->thirdPartsAccess,$syncIntegration);
        }
        return $jobs;

    }






}
