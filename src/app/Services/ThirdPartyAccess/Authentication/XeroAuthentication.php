<?php
namespace App\Services\ThirdPartyAccess\Authentication;

use App\Models\Integrations\ThirdPartyAccess;
use App\Services\HttpRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class XeroAuthentication
{


    const XERO_HOST = 'https://identity.xero.com';

    public static function getAccessToken($thirdPartyAccess): ?string
    {
        Log::info('Xero getAccessToken');

        if ($thirdPartyAccess->access_token && self::validateToken($thirdPartyAccess->access_token)) {
            Log::info('token valid');
            return $thirdPartyAccess->access_token;
        }
        if ($thirdPartyAccess->refresh_token) {
            Log::info('refresh token');
            $res = self::getAccessTokenUsingRefreshToken($thirdPartyAccess);
        } else {
            $res = self::getAccessTokenUsingCode($thirdPartyAccess);
        }
        if(!$res)
            return null;

        self::validateXeroResponse($res);
        self::saveResponse($thirdPartyAccess, $res);

        return $thirdPartyAccess->access_token;
    }

    private static function getAccessTokenUsingRefreshToken(ThirdPartyAccess $thirdPartyAccess)
    {
        $response = HttpRequest::post(self::XERO_HOST . '/connect/token', [
            'grant_type' => 'refresh_token',
            'client_id' => $thirdPartyAccess->client_id,
            'client_secret' => $thirdPartyAccess->client_secret,
            'refresh_token' => $thirdPartyAccess->refresh_token,
        ], format: 'form');

        if (!$response->successful()) {
            Log::error("Xero refresh failed: " . $response->body());
            throw new Exception("Xero refresh failed.");
        }

        return $response->json();
    }

    private static function getAccessTokenUsingCode(ThirdPartyAccess $thirdPartyAccess)
    {
        if(! $thirdPartyAccess->client_secret || !$thirdPartyAccess->access_key || !$thirdPartyAccess->client_id)
            return null;
        try {
            $response = HttpRequest::post(self::XERO_HOST . '/connect/token', [
                'grant_type' => 'authorization_code',
                'client_id' => $thirdPartyAccess->client_id,
                'client_secret' => $thirdPartyAccess->client_secret,
                'code' => $thirdPartyAccess->access_key,
                'redirect_uri' => route('xero.callback', ['merchant' => $thirdPartyAccess->merchant_id], true),
            ], format: 'form');

            if (!$response->successful()) {
                Log::error("Xero code grant failed: " . $response->body());
                throw new Exception("Xero code grant failed.");
            }

            return $response->json();
        }catch (Throwable $e) {
            Log::error("Xero getAccessTokenUsingCode failed: " . $e->getMessage());
            return null;
        }
    }

    private static function validateXeroResponse($res): void
    {
        if (!isset($res['access_token'])) {
            throw new HttpException(422, 'No access token returned from Xero.');
        }
    }

    private static function saveResponse(ThirdPartyAccess $thirdPartyAccess, $res): void
    {
        $thirdPartyAccess->update([
            'access_token' => $res['access_token'],
            'refresh_token' => $res['refresh_token'] ?? $thirdPartyAccess->refresh_token,
            'expires_at' => now()->addSeconds($res['expires_in']),
        ]);
    }

    public static function validateToken($accessToken): bool
    {
        Log::info('validateToken');
        $response = HttpRequest::get('https://api.xero.com/connections', headers: [
            'Authorization' => 'Bearer ' . $accessToken,
        ]);

        return $response->ok();
    }

    public static function getCode($thirdPartyAccess): ?ThirdPartyAccess
    {
        return $thirdPartyAccess;
    }
    public static function disconnect($thirdPartyAccess, $fullReset = false): bool
    {
        $thirdPartyAccess->delete();
        return true;
    }

    public static function getThirdPartyAccess($type,$merchantId=null)
    {
        $thirdPartyAccess=ThirdPartyAccess::query()->where("type", $type);
        if($merchantId){
            $thirdPartyAccess->where("merchant_id", $merchantId);
        }
        return $thirdPartyAccess->first();
    }
}
