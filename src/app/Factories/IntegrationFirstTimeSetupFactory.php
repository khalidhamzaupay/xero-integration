<?php


namespace App\Factories;

use App\Enums\IntegrationsType;
use App\Services\ThirdPartyAccess\FirstTimeSetup\XeroIntegrationFirstTimeSetupService;
class IntegrationFirstTimeSetupFactory
{
    static public function make($type)
    {
        return match ($type) {
            IntegrationsType::Xero->value => new XeroIntegrationFirstTimeSetupService(),
            default => null,
        };
    }
}
