<?php

namespace App\Http\Resources\Xero;

use App\Enums\Xero\XeroAccountCodesEnum;
use App\Enums\Xero\XeroInvoiceStatusEnum;
use App\Enums\Xero\XeroTaxTypesEnum;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class XeroCreditResource extends JsonResource
{

    public function toArray($request): array
    {
        $fields=config('xero.mapping.credits.fields');

        return [
            "Type" => 'RECEIVE-OVERPAYMENT',
            "Contact" => [
                "ContactID" => $this->customer?->xeroMapping($this->{$fields['merchant_id']})?->first()?->third_party_id,
            ],
            "BankAccount" => [
                "Code" => $this->payment?->paymentMethod?->xeroMapping($this->{$fields['merchant_id']})?->first()?->third_party_id,
            ],
            "Date" => $this->{$fields['date']}
                ? Carbon::parse($this->{$fields['date']})->format('Y-m-d')
                : null,
            "Status" => XeroInvoiceStatusEnum::AUTHORISED->value,
            "LineAmountTypes"=> "NoTax",
            "LineItems" => [
                [
                    "Description" => $this->{$fields['description']} ?? 'Credit',
                    "UnitAmount"  => (float) $this->{$fields['amount']},
//                    "AccountCode" => $this->account_code ?? '',
                ]
            ]
        ];
    }
}
