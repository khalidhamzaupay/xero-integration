<?php


namespace App\Services\ThirdPartyAccess\FirstTimeSetup;


use App\Factories\AuthenticationFactory;
use App\Http\Resources\ThirdPartyChartOfAccountsAccount\ThirdPartyChartOfAccountsAccountResource;
use App\Models\Integrations\ThirdPartyAccess;
use App\Models\Integrations\ThirdPartyChartOfAccountsAccount;
use App\Models\Integrations\ThirdPartyOrganization;
use App\Services\Adaptors\Get\GetChartOfAccountsAdaptorXeroService;
use App\Services\Adaptors\Get\GetThirdPartyTaxesAdaptorXeroService;
use App\Services\ThirdPartyAccess\Authentication\GenerateXeroAuthLink;

class XeroIntegrationFirstTimeSetupService
{
    public static function setup($thirdPartyAccess): ThirdPartyAccess|array
    {
        try {
            // Authenticate and get access token
            $accessToken =AuthenticationFactory::make($thirdPartyAccess->type)->getAccessToken($thirdPartyAccess);

            if (!$accessToken) {
                $generateXeroAuthLink = new GenerateXeroAuthLink();
                return $generateXeroAuthLink->execute($thirdPartyAccess)+['third_party_access'=>$thirdPartyAccess];
            }
        } catch (\Exception $exception) {
            throw new \Exception('Xero Authentication Failed');
        }

        try {
            $adaptor_services = [
                GetChartOfAccountsAdaptorXeroService::class,
                GetThirdPartyTaxesAdaptorXeroService::class,
            ];
            foreach ($adaptor_services as $service) {
                (new $service($thirdPartyAccess))->import();
            }
        } catch (\Exception $exception) {
            throw new \Exception('Xero Setup Import Process Failed');
        }

        // Fetch chart of accounts + organizations for merchant
        $thirdPartyAccounts = ThirdPartyChartOfAccountsAccount::where('merchant_id', $thirdPartyAccess->merchant_id)
            ->where('integration_type', $thirdPartyAccess->type)
            ->get();

        $thirdPartyOrganizations = ThirdPartyOrganization::where('third_party_access_id', $thirdPartyAccess->id)
            ->where('integration_type', $thirdPartyAccess->type)
            ->get();

        return [
            "third_party_access" => $thirdPartyAccess,
            "third_party_organizations" => $thirdPartyOrganizations,
            "sale_accounts" => ThirdPartyChartOfAccountsAccountResource::collection($thirdPartyAccounts->where('type', 'REVENUE')),
            "purchase_accounts" => ThirdPartyChartOfAccountsAccountResource::collection($thirdPartyAccounts->where('type', 'COGS')),
            "expense_accounts" => ThirdPartyChartOfAccountsAccountResource::collection($thirdPartyAccounts->where('type', 'EXPENSE')),
            "expense_payment_accounts" => ThirdPartyChartOfAccountsAccountResource::collection($thirdPartyAccounts->whereIn('type', ['CURRENT', 'BANK'])),
            "payment_accounts" => ThirdPartyChartOfAccountsAccountResource::collection($thirdPartyAccounts->whereIn('type', ['CURRENT', 'BANK', 'EQUITY'])),
        ];
    }
}
