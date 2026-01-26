<?php

namespace App\Http\Resources\ThirdPartyAccess;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ThirdPartyAccessResource extends JsonResource
{

    public function data(Request $request): array
    {
        return [

            'id'                                  => $this->id,
            'type'                                => $this->type,
            'access_key'                          => $this->access_key,
            'access_token'                        => $this->access_token,
            'client_id'                           => $this->client_id,
            'client_secret'                       => $this->client_secret,
            'starts_at'                           => $this->starts_at,
            'expires_at'                          => $this->expires_at,
            'merchant_id'                         => $this->merchant_id,
            'organization_id'                     => $this->organization_id,
            'assets_account_id'                   => $this->assets_account_id,
            'sale_account_id'                     => $this->sale_account_id,
            'purchase_account_id'                 => $this->purchase_account_id,
            'default_purchase_payment_account_id' => $this->default_purchase_payment_account_id,
            'expense_account_id'                  => $this->expense_account_id,
            'default_expense_payment_account_id'  => $this->default_expense_payment_account_id,
        ];
    }
}

