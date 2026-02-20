<?php

namespace App\Http\Resources\Xero;

use App\Enums\Xero\XeroAccountCodesEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroReturnInvoiceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'CreditNotes' => [[
                'Type' => XeroAccountCodesEnum::CREDIT_NOTE->value,
                'CreditNoteNumber' => $this->credit_note_number,
                'Date' => optional($this->date)?->format('Y-m-d'),
                'Contact' => [
                    'ContactID' => $this->customer?->xero_mapping_id,
                ],
                'LineItems' => XeroReturnInvoiceItemResource::collection($this->items)->resolve(),
                'Allocations' => [[
                    'Invoice' => [
                        'InvoiceID' => $this->invoice?->xero_mapping_id,
                    ],
                    'Amount' => (float) $this->amount,
                ]],
                'Status' => 'AUTHORISED',
            ]]
        ];
    }
}
