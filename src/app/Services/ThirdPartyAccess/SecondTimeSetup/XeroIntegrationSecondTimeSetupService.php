<?php

namespace App\Services\ThirdPartyAccess\SecondTimeSetup;

use App\Factories\AuthenticationFactory;
use App\Http\Resources\ThirdPartyChartOfAccountsAccount\ThirdPartyChartOfAccountsAccountResource;
use App\Models\Integrations\ThirdPartyChartOfAccountsAccount;
use App\Models\Integrations\ThirdPartyOrganization;
use App\Services\Adaptors\Get\GetChartOfAccountsAdaptorXeroService;
use App\Services\Adaptors\Get\GetThirdPartyTaxesAdaptorXeroService;

class XeroIntegrationSecondTimeSetupService
{

    public static function setup($thirdPartyAccess)
    {
        $check_second_time_update = ThirdPartyChartOfAccountsAccount::where('third_party_access_id', $thirdPartyAccess->id)->first();
        if ($check_second_time_update) {
            return [
                "third_party_access" => $thirdPartyAccess,
            ];
        }
        try {
            AuthenticationFactory::make($thirdPartyAccess->type)->getAccessToken($thirdPartyAccess);
        } catch (\Exception $exception) {
            throw  new \Exception('This Credentials Authentication Failed To Authenticate');
        }

        ThirdPartyChartOfAccountsAccount::where('clinic_id', $thirdPartyAccess->clinic_id)->where('integration_type', $thirdPartyAccess->type)->delete();
        try {
            $adaptor_services = [
                GetChartOfAccountsAdaptorXeroService::class,
                GetThirdPartyTaxesAdaptorXeroService::class,
            ];
            foreach ($adaptor_services as $service) {
                (new $service($thirdPartyAccess))->import();
            }
        } catch (\Exception $exception) {
            throw  new \Exception('The Setup Import Process Failed');
        }
        $thirdPartyAccounts = ThirdPartyChartOfAccountsAccount::where('clinic_id', $thirdPartyAccess->clinic_id)
            ->where('integration_type', $thirdPartyAccess->type)
            ->get();

        $thirdPartyOrganizations = ThirdPartyOrganization::where('third_party_access_id', $thirdPartyAccess->id)
            ->where('integration_type', $thirdPartyAccess->type)
            ->get();

        return [
            "third_party_access" => $thirdPartyAccess,
            "third_party_organizations" => $thirdPartyOrganizations,
            "sale_accounts" => ThirdPartyChartOfAccountsAccountResource::collection($thirdPartyAccounts->where('type', 'REVENUE')),
            "purchase_accounts" => ThirdPartyChartOfAccountsAccountResource::collection($thirdPartyAccounts->whereIn('type', ['EXPENSE','DIRECTCOSTS','INVENTORY'])),
            "expense_accounts" => ThirdPartyChartOfAccountsAccountResource::collection($thirdPartyAccounts->where('type', 'EXPENSE')),
            "expense_payment_accounts" => ThirdPartyChartOfAccountsAccountResource::collection($thirdPartyAccounts->whereIn('type', ['CURRENT', 'BANK'])),
            "payment_accounts" => ThirdPartyChartOfAccountsAccountResource::collection($thirdPartyAccounts->whereIn('type', ['CURRENT', 'BANK', 'EQUITY'])),
            "assets_accounts" => ThirdPartyChartOfAccountsAccountResource::collection($thirdPartyAccounts->whereIn('type', ['CURRENT', 'FIXED', 'INVENTORY'])),
        ];
    }


}
