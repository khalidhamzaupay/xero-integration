<?php


namespace App\Factories;

use App\Enums\IntegrationsType;
use App\Services\ThirdPartyAccess\Configurations\GetXeroIntegrationPaymentMethodConfigurationsService;

class IntegrationPaymentMethodFactory
{
    static public function make($type)
    {
        return match ($type) {
            IntegrationsType::Xero->value => new GetXeroIntegrationPaymentMethodConfigurationsService(),
            default => null,
        };
    }
}
