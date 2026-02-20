<?php

namespace App\Models;

use App\Enums\IntegrationsType;
use App\Models\Integrations\ThirdPartyMapping;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PaymentMethod extends Model
{
    protected $table;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('xero.mapping.payment_methods.table', 'payment_methods');
    }

    public function xeroMapping($merchant_id =null):MorphOne
    {
        return $this->morphOne(ThirdPartyMapping::class,'object')->where('type',IntegrationsType::Xero->value)->where('merchant_id',$merchant_id);
    }
}
