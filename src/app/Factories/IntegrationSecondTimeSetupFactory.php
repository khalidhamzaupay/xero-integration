<?php

namespace App\Factories;

use App\Enums\IntegrationsType;
use App\Services\ThirdPartyAccess\SecondTimeSetup\XeroIntegrationSecondTimeSetupService;

class IntegrationSecondTimeSetupFactory
{
    static public function make($type)
    {
        return match ($type) {
            IntegrationsType::Xero->value => new XeroIntegrationSecondTimeSetupService(),
            default                            => null,
        };
    }
}
