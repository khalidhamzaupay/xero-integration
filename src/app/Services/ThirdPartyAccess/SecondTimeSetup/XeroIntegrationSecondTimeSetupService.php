<?php

namespace App\Services\ThirdPartyAccess\SecondTimeSetup;

use App\Factories\AuthenticationFactory;
use App\Http\Resources\ThirdPartyChartOfAccount\ThirdPartyChartOfAccountResource;
use App\Models\Integrations\ThirdPartyChartOfAccount;
use App\Models\Integrations\ThirdPartyOrganization;
use App\Services\Adaptors\Xero\Get\GetChartOfAccountsAdaptorXeroService;
use App\Services\Adaptors\Xero\Get\GetThirdPartyTaxesAdaptorXeroService;

class XeroIntegrationSecondTimeSetupService
{

    public static function setup($thirdPartyAccess)
    {

        try {
            AuthenticationFactory::make($thirdPartyAccess->type)->getAccessToken($thirdPartyAccess);
        } catch (\Exception $exception) {
            throw  new \Exception('This Credentials Authentication Failed To Authenticate');
        }

        ThirdPartyChartOfAccount::where('merchant_id', $thirdPartyAccess->merchant_id)->where('integration_type', $thirdPartyAccess->type)->delete();
        try {
            $adaptor_services = config('integrationAdaptors.Xero.get');
            foreach ($adaptor_services as $service) {
                (new $service($thirdPartyAccess))->import();
            }
        } catch (\Exception $exception) {
            throw  new \Exception('The Setup Import Process Failed');
        }
        $thirdPartyAccounts = ThirdPartyChartOfAccount::where('merchant_id', $thirdPartyAccess->merchant_id)
            ->where('integration_type', $thirdPartyAccess->type)
            ->get();

        $thirdPartyOrganizations = ThirdPartyOrganization::where('third_party_access_id', $thirdPartyAccess->id)
            ->where('integration_type', $thirdPartyAccess->type)
            ->get();

        return [
            "third_party_access" => $thirdPartyAccess,
            "third_party_organizations" => $thirdPartyOrganizations,
            "sale_accounts" => ThirdPartyChartOfAccountResource::collection($thirdPartyAccounts->where('type', 'REVENUE')),
            "purchase_accounts" => ThirdPartyChartOfAccountResource::collection($thirdPartyAccounts->whereIn('type', ['EXPENSE','DIRECTCOSTS','INVENTORY'])),
            "expense_accounts" => ThirdPartyChartOfAccountResource::collection($thirdPartyAccounts->where('type', 'EXPENSE')),
            "expense_payment_accounts" => ThirdPartyChartOfAccountResource::collection($thirdPartyAccounts->whereIn('type', ['CURRENT', 'BANK'])),
            "payment_accounts" => ThirdPartyChartOfAccountResource::collection($thirdPartyAccounts->whereIn('type', ['CURRENT', 'BANK', 'EQUITY'])),
            "assets_accounts" => ThirdPartyChartOfAccountResource::collection($thirdPartyAccounts->whereIn('type', ['CURRENT', 'FIXED', 'INVENTORY'])),
        ];
    }


}
