<?php

namespace App\Http\Resources\Xero;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class XeroInvoiceItemResource extends JsonResource
{
    public function toArray($request): array
    {
        $fields=config('xero.mapping.invoice_items.fields');
        $product_fields=config('xero.mapping.products.fields');
        $invoice_fields=config('xero.mapping.invoices.fields');
        // Sanitize description to avoid special characters
        $description = Str::of($this->{$fields['description']} ?? '')
            ->replaceMatches('/[^\w\s\-]/', '')
            ->limit(400);

        return [
            "ItemCode"    => $this->product?->{$product_fields['code']},
            "Description" => $description,
            "Quantity"    => (float) $this->{$fields['quantity']},
            "UnitAmount"  => (float) $this->{$fields['unit_amount']},
            "AccountCode" => $this->invoice?->merchant?->xeroThirdPartyAccess?->saleAccount?->mapping_id,
//            "TaxType"     => $this->{$fields['taxGroup']}
//                ?->xeroMapping($this->invoice?->{$invoice_fields['merchant_id']})?->first()?->third_party_id,
            "TaxAmount"   => (float) $this->{$fields['tax_amount']},
            "DiscountRate"=> (float) ($this->{$fields['discount_rate']} ?? 0),
        ];
    }
}
