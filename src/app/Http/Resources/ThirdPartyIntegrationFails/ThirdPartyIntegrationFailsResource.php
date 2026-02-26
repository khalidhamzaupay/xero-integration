<?php

namespace App\Http\Resources\ThirdPartyIntegrationFails;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ThirdPartyIntegrationFailsResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id'                  => $this->id,
            'sync_integration_id' => $this->sync_integration_id,
            'type'                => $this->type,
            'error_message'       => $this->message,
            'merchant_id'         => $this->merchant_id,
            'failed_at'           => $this->created_at?->toDateTimeString(),

            'failed_object' => [
                'id'        => $this->object_id,
                'type'      => $this->object_type,
            ],

            'sync_job_status' => $this->syncIntegration?->status,
        ];
    }
}

