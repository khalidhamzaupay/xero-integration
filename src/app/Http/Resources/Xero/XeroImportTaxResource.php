<?php


namespace App\Http\Resources\Xero;

use App\Enums\IntegrationsType;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class XeroImportTaxResource extends JsonResource
{
    public function data(Request $request): array
    {
        return [
            "mapping_id" => $this['TaxType'] ?? null,
            "name" => $this['Name'] ?? null,
            "integration_type" => IntegrationsType::Xero->value,
            "active" => ($this['Status'] ?? '') === 'ACTIVE',
            "tax_percentage" => $this['EffectiveRate'] ?? null,
        ];
    }
}
