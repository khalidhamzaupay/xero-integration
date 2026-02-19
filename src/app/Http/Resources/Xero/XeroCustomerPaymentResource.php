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
                "InvoiceID" => "",
            ],
            "Account" => [
                "Code" => $this->payment->paymentMethod?->xeroMapping?->third_party_id,
            ],
            "Date" => "",
            "Amount" => "",
            "Reference" => "",
        ];
    }
}
