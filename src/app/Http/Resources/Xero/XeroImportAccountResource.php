<?php

namespace App\Http\Resources\Xero;

use App\Enums\IntegrationsType;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class XeroImportAccountResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "mapping_id"       => $this['Code'] ?? null, // code
            "name"             => $this['Name'] ?? null,
            "type"             => $this['Type'] ?? null, // e.g., REVENUE, EXPENSE
            "integration_type" => IntegrationsType::Xero->value,
            "active"           => ($this['Status'] ?? '') === 'ACTIVE',
        ];
    }
}
