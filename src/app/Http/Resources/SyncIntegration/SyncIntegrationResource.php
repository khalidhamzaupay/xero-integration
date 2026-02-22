<?php

namespace App\Http\Resources\SyncIntegration;

use Illuminate\Http\Resources\Json\JsonResource;

class SyncIntegrationResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'merchant_id'=> $this->merchant_id,
            'method'     => $this->method,
            'type'       => $this->type,
            'status'     => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}

