<?php

namespace App\Console\Commands;

use App\Enums\IntegrationsType;
use App\Models\Integrations\ThirdPartyAccess;
use App\Services\SyncIntegration\IntegrationExportDataService;
use Illuminate\Console\Command;

class XeroDailySendDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xero:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send data to Xero';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $allXeroThirdPartyAccess = ThirdPartyAccess::where('type', IntegrationsType::Xero->value)->get();
        foreach ($allXeroThirdPartyAccess as $xeroThirdPartyAccess)
        {
            if($xeroThirdPartyAccess->merchant_id!=null) {
                $integrationExportDataService = new IntegrationExportDataService($xeroThirdPartyAccess->id);
                $syncIntegrations = $integrationExportDataService->export();            }
        }
    }
}
