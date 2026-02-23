<?php

namespace App\Http\Resources\Xero;

use App\Enums\Xero\XeroAccountCodesEnum;
use App\Enums\Xero\XeroContactStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroInvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        $fields=config('xero.mapping.invoices.fields');
        return [
            "Type" => XeroAccountCodesEnum::INVOICE_RECEIVABLE->value, // Accounts receivable

            "Contact" => [
                // uses your existing relation + mapping
                "ContactID" => $this->client?->xeroMapping($this->{$fields['merchant_id']})?->first()?->third_party_id,
            ],

            "Date" => optional($this->{$fields['date']})?->format('Y-m-d'),

            "DueDate" => optional($this->{$fields['due_date']})?->format('Y-m-d'),

            "LineItems" => XeroInvoiceItemResource::collection($this->items)->resolve(),

            "Status" => $this->status,

            "Reference" => $this->{$fields['reference']},

            "Notes" => $this->{$fields['notes']},

            "SubTotal" => (float) $this->{$fields['subtotal']},

            "TotalTax" => (float) $this->{$fields['total_tax']},

            "Total" => (float) $this->{$fields['total']},
        ];
    }
}
