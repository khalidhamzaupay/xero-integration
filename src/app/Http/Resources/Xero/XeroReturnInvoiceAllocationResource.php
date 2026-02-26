<?php

namespace App\Http\Resources\Xero;

use App\Enums\Xero\XeroAccountCodesEnum;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class XeroReturnInvoiceAllocationResource extends JsonResource
{
    public function toArray($request): array
    {
        $fields=config('xero.mapping.refunds.fields');
        return [
                    'Invoice' => [
                        'InvoiceID' => $this->invoice?->xeroMapping()?->first()?->third_party_id,
                    ],
                    'Amount' => (float) $this->{$fields['amount']},
        ];
    }
}
