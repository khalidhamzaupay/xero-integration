<?php

namespace App\Http\Resources\ThirdPartyMapping;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ThirdPartyMappingResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'type'             => $this->type,
            'tag'              => $this->third_party_tag,
            'xero_id'          => $this->third_party_id,
            'xero_code'        => $this->third_party_code,
            'merchant_id'      => $this->merchant_id,
            'local_object'     => [
                'id'   => $this->object_id,
                'type' => $this->object_type,
            ],
            'created_at'       => $this->created_at?->toDateTimeString(),
        ];
    }
}

