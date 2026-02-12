<?php

namespace App\Services\ThirdPartyAccess;

use App\Enums\IntegrationsType;
use App\Factories\IntegrationSecondTimeSetupFactory;
use App\Models\Integrations\ThirdPartyAccess;
use Illuminate\Database\Eloquent\Model;

class SecondTimeSetupThirdPartyAccessService
{

    public function handle(ThirdPartyAccess $thirdPartyAccess,array $data)
    {
        $updateThirdPartyAccessService = new UpdateThirdPartyAccessService();
        $updateThirdPartyAccessService = $updateThirdPartyAccessService->handle($thirdPartyAccess,$data);
        $thirdPartyAccess->refresh();
        $data=IntegrationSecondTimeSetupFactory::make($thirdPartyAccess->type)?->setup($thirdPartyAccess);
        return $data??$thirdPartyAccess;
    }

}
