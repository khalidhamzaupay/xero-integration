<?php

namespace App\Factories;

use App\Enums\IntegrationsType;
use App\Services\ThirdPartyAccess\Authentication\XeroAuthentication;


class AuthenticationFactory
{
    static public function make($type)
    {
        return match ($type) {
            IntegrationsType::Xero->value       => new XeroAuthentication(),
            default                             => null,
        };
    }
}
