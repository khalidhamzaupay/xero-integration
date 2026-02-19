<?php

namespace App\Http\Resources\Xero;


use App\Enums\Xero\XeroAccountCodesEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroInvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        $data = [
            "Type" => XeroAccountCodesEnum::INVOICE_RECEIVABLE->value, // Accounts receivable type for invoices
            "Contact" => [
                "ContactID" => $this->client?->xeroMapping($this->clinic_id)?->first()?->third_party_id,
            ],
            "Date" => "",
            "DueDate" => "",
            "LineItems" => XeroInvoiceItemResource::collection($this->invoiceItems)->toArray(request()),
            "Status" => "",
            "Reference" => "",
            "Notes" => "",
            "SubTotal"=> "",
            "TotalTax"=> "",
            "Total"=> "",
        ];



        return $data;
    }
}

