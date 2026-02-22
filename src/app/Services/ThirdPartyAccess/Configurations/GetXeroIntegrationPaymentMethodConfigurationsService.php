<?php

namespace App\Services\ThirdPartyAccess\Configurations;

use App\Enums\IntegrationsType;
use App\Http\Resources\ThirdPartyChartOfAccount\ThirdPartyChartOfAccountResource;
use App\Models\Integrations\PaymentMethod;
use App\Models\Integrations\ThirdPartyChartOfAccount;


class GetXeroIntegrationPaymentMethodConfigurationsService
{
    public static function get($thirdPartyAccess): array|null
    {
        $paymentMethodName=config('xero.mapping.payment_methods.fields.name');
        $paymentMethods = PaymentMethod::query()
            ->with('xeroMapping', function ($q) use ($thirdPartyAccess) {
                $q->where('third_party_mappings.merchant_id', $thirdPartyAccess->merchant_id);
            })
            ->get()
            ->map(function ($paymentMethod) use ($paymentMethodName){
                return [
                    "id" => $paymentMethod->xeroMapping?->id,
                    "object_id" => $paymentMethod->id,
                    "name" => $paymentMethod->$paymentMethodName,
                    "third_party_id" => $paymentMethod->xeroMapping?->third_party_id,
                ];
            });

        $thirdPartyAccounts = ThirdPartyChartOfAccount::where('merchant_id', $thirdPartyAccess->merchant_id)
            ->whereIn('type', ['BANK', 'CURRENT'])
            ->where('integration_type', IntegrationsType::Xero->value)
            ->get();

        return [
            "payment_methods" => $paymentMethods,
            "payment_accounts" => ThirdPartyChartOfAccountResource::collection($thirdPartyAccounts),
        ];
    }
}
