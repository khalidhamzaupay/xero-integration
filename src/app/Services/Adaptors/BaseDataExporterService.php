<?php


namespace App\Services\Adaptors;

use App\Factories\AuthenticationFactory;
use App\Models\Integrations\ThirdPartyAccess;
use App\Traits\ThirdPartyMappingTrait;

abstract class  BaseDataExporterService
{
    use ThirdPartyMappingTrait;

    /**
     * @throws \Exception
     */
    public function __construct(public string|ThirdPartyAccess|null $thirdPartyAccess, public $syncIntegrationId = null)
    {
    }

    public function authenticate()
    {
        $accessToken = AuthenticationFactory::make($this->getType())->getAccessToken($this->thirdPartyAccess);
        if (is_string($accessToken)) {
            $this->thirdPartyAccess->access_token = $accessToken;
        } elseif ($accessToken instanceof ThirdPartyAccess) {
            $this->thirdPartyAccess = $accessToken;
        }
        return null;
    }


}
