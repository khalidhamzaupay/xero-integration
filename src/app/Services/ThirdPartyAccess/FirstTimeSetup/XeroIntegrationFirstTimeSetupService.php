<?php


namespace App\Services\ThirdPartyAccess\FirstTimeSetup;


use App\Factories\AuthenticationFactory;
use App\Models\Integrations\ThirdPartyAccess;
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
        return $thirdPartyAccess;

    }
}
