<?php

namespace App\Http\Resources\Xero;

use Illuminate\Http\Resources\Json\JsonResource;

class XeroReturnInvoiceItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'Description' => $this->description,
            'Quantity' => (float) $this->quantity,
            'UnitAmount' => (float) $this->unit_amount,
            'ItemCode' => $this->item?->code,
            'TaxType' => $this->tax_type,
        ];
    }
}

