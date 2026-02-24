<?php

namespace App\Http\Resources\Xero;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class XeroCustomerPaymentResource extends JsonResource
{

    public function toArray($request): array
    {
        $fields=config('xero.mapping.customer_payments.fields');
        $invoiceId = $this->invoice?->xeroMapping?->third_party_id;
        return [
            "Invoice" => [
                "InvoiceID" => $invoiceId,
            ],
            "Account" => [
                "Code" => (string)$this->payment?->paymentMethod?->xeroMapping->third_party_id,
            ],
            "Date" => $this->{$fields['date']}
                ? Carbon::parse($this->{$fields['date']})->format('Y-m-d')
                : null,
            "Amount" => (float) $this->{$fields['amount']},
            "Reference" => $this->{$fields['reference']},
        ];
    }
}
