<?php

namespace App\Http\Resources\ThirdPartyOrganization;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ThirdPartyOrganizationResource extends JsonResource
{

    public function toArray($request): array
    {
        return [

            'id'                                  => $this->id,
            'type'                                => $this->integration_type,
            'third_party_access_id'               => $this->third_party_access_id,
            'third_party_id'                      => $this->third_party_id,
            'merchant_id'                         => $this->merchant_id,
            'name'                                => $this->name,

        ];
    }
}

