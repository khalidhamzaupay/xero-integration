<?php

namespace App\Services\ThirdPartyAccess;

use App\Models\Integrations\ThirdPartyAccess;
use Exception;
use Illuminate\Database\Eloquent\Model;
use App\Factories\IntegrationFirstTimeSetupFactory;

class StoreThirdPartyAccessService
{

    /**
     * @throws \Exception
     */
    public function handle(array $data): Model|ThirdPartyAccess|array
    {
        $thirdPartyAccess = ThirdPartyAccess::query()->withTrashed()->updateOrCreate(
            [ 'type' => $data['type'] ] + ((isset($data['merchant_id'])) ? [ 'merchant_id' => $data['merchant_id'] ] : []),
            $data + [ "deleted_at" => null ]
        );
        try{
            $data = IntegrationFirstTimeSetupFactory::make($thirdPartyAccess->type)?->setup($thirdPartyAccess);
        }catch(Exception $exception){
            $thirdPartyAccess->update(
                [
                    "access_token" => null,
                    "deleted_at"   => now(),
                ]
            );
            throw $exception;
        }
        return $data ?? $thirdPartyAccess;
    }



}
