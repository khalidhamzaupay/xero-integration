<?php

namespace App\Http\Resources\Xero;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class XeroInvoiceItemResource extends JsonResource
{
    public function toArray($request): array
    {
        // Sanitize description to avoid special characters
        $description = Str::of($this->description ?? '')
            ->replaceMatches('/[^\w\s\-]/', '')
            ->limit(400);

        return [
            "ItemCode"    => $this->item?->code,
            "Description" => $description,
            "Quantity"    => (float) $this->quantity,
            "UnitAmount"  => (float) $this->unit_price,
            "AccountCode" => $this->invoice
                ->clinic?->xeroThirdPartyAccess?->saleAccount?->mapping_id,
            "TaxType"     => $this->taxGroup
                ?->xeroMapping($this->invoice?->merchant_id)?->first()?->third_party_id,
            "TaxAmount"   => (float) $this->tax_amount,
            "DiscountRate"=> (float) ($this->discount_rate ?? 0),
        ];
    }
}
