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
                'CreditNoteNumber' => "",
                'Date' => "",
                'Contact' => [
                    'ContactID' => "",
                ],
                'LineItems' => "",

                'Allocations' => [[
                    'Invoice' => [
                        'InvoiceID' => "",
                    ],
                    'Amount' => "",
                ]],

                'Status' => 'AUTHORISED',
            ]]
        ];
    }
}

