<?php

namespace App\Http\Resources\Xero;

use App\Enums\Xero\XeroAccountCodesEnum;
use App\Enums\Xero\XeroInvoiceStatusEnum;
use App\Enums\Xero\XeroTaxTypesEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroCreditResource extends JsonResource
{

    public function toArray($request): array
    {
        $accountCode = "";
        return [
            "Type" => XeroAccountCodesEnum::CREDIT_NOTE->value,
            "Contact" => [
                "ContactID" => $this->client?->xeroMapping($this->merchant_id)?->first()?->third_party_id,
            ],
            "Date" => "",
            "Status" => XeroInvoiceStatusEnum::AUTHORISED->value,
            "LineItems" => [
                [
                    "Description" => "",
                    "UnitAmount" => "",
                    "AccountCode" => "",
                    "TaxType" => XeroTaxTypesEnum::NONE->value,
                ]
            ],
            "Reference" => "",
        ];
    }
}
