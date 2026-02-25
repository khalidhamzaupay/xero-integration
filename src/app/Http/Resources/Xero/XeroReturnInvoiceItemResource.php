<?php

namespace App\Http\Resources\Xero;

use App\Enums\Xero\XeroTaxTypesEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroReturnInvoiceItemResource extends JsonResource
{
    public function toArray($request): array
    {
        $fields=config('xero.mapping.refund_items.fields');
        $product_fields=config('xero.mapping.products.fields');
        return [
            'Description' => $this->{$fields['description']},
            'Quantity' => (float) $this->{$fields['quantity']},
            'UnitAmount' => (float) $this->{$fields['unit_amount']},
            'ItemCode' => $this->product?->{$product_fields['code']},
            "AccountCode" => $this->refund->invoice?->merchant?->xeroThirdPartyAccess?->saleAccount?->mapping_id,
            "TaxType"     => XeroTaxTypesEnum::NONE->value,
        ];
    }
}

