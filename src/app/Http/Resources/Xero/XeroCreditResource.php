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
        return [
            "Type" => XeroAccountCodesEnum::CREDIT_NOTE->value,
            "Contact" => [
                "ContactID" => $this->client?->xero_mapping_id,
            ],
            "Date" => optional($this->date)?->format('Y-m-d'),
            "Status" => XeroInvoiceStatusEnum::AUTHORISED->value,
            "LineItems" => [
                [
                    "Description" => $this->description ?? 'Credit',
                    "UnitAmount"  => (float) $this->amount,
                    "AccountCode" => $this->account_code ?? '',
                    "TaxType"     => XeroTaxTypesEnum::NONE->value,
                ]
            ],
            "Reference" => $this->reference,
        ];
    }
}
