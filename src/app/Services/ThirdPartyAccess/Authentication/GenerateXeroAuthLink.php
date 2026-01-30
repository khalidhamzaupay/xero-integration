<?php

namespace App\Services\ThirdPartyAccess\Authentication;



use App\Models\Integrations\ThirdPartyAccess;

class GenerateXeroAuthLink
{
    function execute(ThirdPartyAccess $thirdPartyAccess)
    {
        $url = "https://login.xero.com/identity/connect/authorize?" . http_build_query([
                'response_type' => 'code',
                'client_id'     => $thirdPartyAccess->client_id,
                'redirect_uri'  => route('xero.callback'),
                'scope'         => env('XERO_CLIENT_SCOPE'),
                'state'         => $thirdPartyAccess->id,
            ]);
        return [
            'authorizationCodeUrl' => $url,
        ];
    }
}
