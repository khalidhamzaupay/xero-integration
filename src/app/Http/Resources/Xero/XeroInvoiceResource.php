<?php

namespace App\Http\Resources\Xero;

use App\Enums\Xero\XeroAccountCodesEnum;
use App\Enums\Xero\XeroContactStatusEnum;
use App\Enums\Xero\XeroInvoiceStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class XeroInvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        $fields=config('xero.mapping.invoices.fields');
        $internalStatus = $this->{$fields['status']} ?? 'DRAFT';
        return [
            "Type" => XeroAccountCodesEnum::INVOICE_RECEIVABLE->value, // Accounts receivable

            "Contact" => [
                // uses your existing relation + mapping
                "ContactID" => $this->client?->xeroMapping($this->{$fields['merchant_id']})?->first()?->third_party_id,
            ],

            "Date" => $this->{$fields['date']}
                ? Carbon::parse($this->{$fields['date']})->format('Y-m-d')
                : null,

            "DueDate" => $this->{$fields['due_date']}
                ? Carbon::parse($this->{$fields['due_date']})->format('Y-m-d')
                : null,

            "LineItems" => XeroInvoiceItemResource::collection($this->items)->resolve(),

            "Status" => XeroInvoiceStatusEnum::fromInternal($internalStatus)->value,

            "Reference" => $this->{$fields['reference']},

            "Notes" => $this->{$fields['notes']},

            "SubTotal" => (float) $this->{$fields['subtotal']},

            "TotalTax" => 0,

            "Total" => (float) $this->{$fields['total']},
        ];
    }
}
