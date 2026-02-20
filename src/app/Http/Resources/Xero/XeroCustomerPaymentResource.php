<?php

namespace App\Http\Resources\Xero;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroCustomerPaymentResource extends JsonResource
{

    public function toArray($request): array
    {
        $invoiceId = $this->invoice?->xeroMapping?->third_party_id;
        return [
            "Invoice" => [
                "InvoiceID" => $this->invoice?->xero_mapping_id,
            ],
            "Account" => [
                "Code" => $this->payment?->paymentMethod?->xero_mapping_id,
            ],
            "Date" => optional($this->date)?->format('Y-m-d'),
            "Amount" => (float) $this->amount,
            "Reference" => $this->reference,
        ];
    }
}
