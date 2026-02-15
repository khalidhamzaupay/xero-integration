<?php

namespace App\Services\ThirdPartyAccess;

use App\Enums\IntegrationsType;
use App\Factories\IntegrationSecondTimeSetupFactory;
use App\Models\Integrations\ThirdPartyAccess;
use Illuminate\Database\Eloquent\Model;

class UpdateThirdPartyAccessService
{

    public function handle(ThirdPartyAccess $thirdPartyAccess,array $data)
    {
        $update = $thirdPartyAccess->update($data);
        $data['third_party_access'] = $thirdPartyAccess;
        return $data??$thirdPartyAccess;
    }

}
