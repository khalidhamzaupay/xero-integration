<?php


namespace App\Http\Resources\Xero;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroDeleteCreditResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $fields=config('xero.mapping.credits.fields');

        $data = [
            "BankTransactionID" => $this->xeroMapping($this->{$fields['merchant_id']})?->first()?->third_party_id,
            "Type" => "RECEIVE",
            "Status" => "DELETED",

        ];



        return $data;
    }
}
