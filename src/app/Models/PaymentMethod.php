<?php

namespace App\Models;

use App\Enums\IntegrationsType;
use App\Models\Integrations\ThirdPartyMapping;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $table = "payment_methods";

    public function xeroMapping($merchant_id =null):MorphOne
    {
        return $this->morphOne(ThirdPartyMapping::class,'object')->where('type',IntegrationsType::Xero->value)->where('merchant_id',$merchant_id);
    }
}
