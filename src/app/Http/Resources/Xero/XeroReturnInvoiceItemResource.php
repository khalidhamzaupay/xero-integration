<?php

namespace App\Http\Resources\Xero;

use Illuminate\Http\Resources\Json\JsonResource;

class XeroReturnInvoiceItemResource extends JsonResource
{
    public function toArray($request): array
    {

        return [
            'Description' => "",
            'Quantity' => "",
            'UnitAmount' => "",

            'ItemCode' => "",

            'TaxType' =>""?? 'OUTPUT',
        ];
    }
}

