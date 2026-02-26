<?php

namespace App\Services\ThirdPartyAccess\Authentication;

use App\Enums\IntegrationsType;
use App\Models\Integrations\ThirdPartyAccess;
use App\Models\Integrations\ThirdPartyOrganization;
use Illuminate\Support\Facades\Http;

class HandleXeroCallbackService
{
    protected ThirdPartyAccess $thirdPartyAccess;
    protected string $code;

    public function __construct(string $code, ThirdPartyAccess $thirdPartyAccess)
    {
        $this->thirdPartyAccess = $thirdPartyAccess;
        $this->code = $code;
    }

    public function handle(): array
    {

        $tokenData = $this->exchangeCodeForToken();

        $this->updateAccessTokens($tokenData);

        $connections = $this->fetchConnections($tokenData['access_token']);

        $this->saveOrganizations($connections);

        return [
            'message' => 'Xero connected successfully',
        ];
    }

    private function getThirdPartyAccess(): ThirdPartyAccess
    {
        return ThirdPartyAccess::where('merchant_id', $this->merchant_id)
            ->where('type', IntegrationsType::Xero->value)
            ->firstOrFail();
    }

    private function exchangeCodeForToken(): array
    {
        $response = Http::asForm()->post('https://identity.xero.com/connect/token', [
            'grant_type'    => 'authorization_code',
            'code'          => $this->code,
            'client_id'     => $this->thirdPartyAccess->client_id,
            'redirect_uri'  => route('xero.callback'),
            'client_secret' => $this->thirdPartyAccess->client_secret,
        ]);

        if (!$response->successful()) {
            throw new \Exception('Xero token exchange failed');
        }

        return $response->json();
    }

    private function updateAccessTokens(array $tokenData): void
    {
        $this->thirdPartyAccess->update([
            'access_key'    => $this->code,
            'access_token'  => $tokenData['access_token'],
            'refresh_token' => $tokenData['refresh_token'] ?? null,
            'expires_at'    => now()->addSeconds($tokenData['expires_in']),
        ]);
    }

    private function fetchConnections(string $accessToken): array
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer " . $accessToken,
            'Accept'        => 'application/json',
        ])->get('https://api.xero.com/connections');

        if (!$response->successful()) {
            throw new \Exception('Failed to fetch Xero connections');
        }

        return $response->json();
    }

    private function saveOrganizations(array $connections): void
    {
        foreach ($connections as $connection) {
            ThirdPartyOrganization::updateOrCreate(
                [
                    'third_party_id' => $connection['tenantId'],
                    'integration_type'           => IntegrationsType::Xero->value,
                ],
                [
                    'third_party_access_id'=> $this->thirdPartyAccess->id,
                    'name'=> $connection['tenantName'],
                    'merchant_id'=> $this->thirdPartyAccess->merchant_id,
                ]
            );
        }
    }
}
