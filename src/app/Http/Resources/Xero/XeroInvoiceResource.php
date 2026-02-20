<?php

namespace App\Http\Resources\Xero;

use App\Enums\Xero\XeroAccountCodesEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroInvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "Type" => XeroAccountCodesEnum::INVOICE_RECEIVABLE->value, // Accounts receivable

            "Contact" => [
                // uses your existing relation + mapping
                "ContactID" => $this->client?->xeroMapping($this->merchant_id)?->first()?->third_party_id,
            ],

            "Date" => optional($this->invoice_date)?->format('Y-m-d'),

            "DueDate" => optional($this->due_date)?->format('Y-m-d'),

            "LineItems" => XeroInvoiceItemResource::collection($this->invoiceItems)->resolve(),

            "Status" => $this->status, // keep your existing field

            "Reference" => $this->reference,

            "Notes" => $this->notes,

            "SubTotal" => (float) $this->subtotal,

            "TotalTax" => (float) $this->tax_total,

            "Total" => (float) $this->total,
        ];
    }
}
