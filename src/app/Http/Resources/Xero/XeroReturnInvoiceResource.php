<?php

namespace App\Http\Resources\Xero;

use App\Enums\Xero\XeroAccountCodesEnum;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class XeroReturnInvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        $fields=config('xero.mapping.refunds.fields');
        return [
                'Type' => XeroAccountCodesEnum::CREDIT_NOTE->value,
//                'CreditNoteNumber' => $this->credit_note_number,
                'Date' => $this->{$fields['date']}
                    ? Carbon::parse($this->{$fields['date']})->format('Y-m-d')
                    : null,
                'Contact' => [
                    'ContactID' => $this->invoice->client?->xeroMapping()?->first()?->third_party_id,
                ],
                'LineItems' => XeroReturnInvoiceItemResource::collection($this->items)->resolve(),
//                'Allocations' => [[
//                    'Invoice' => [
//                        'InvoiceID' => $this->invoice?->xeroMapping()?->first()?->third_party_id,
//                    ],
//                    'Amount' => (float) $this->{$fields['amount']},
//                ]],
                'Status' => 'AUTHORISED',
        ];
    }
}
