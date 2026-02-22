<?php

namespace App\Models\Integrations;

use App\Enums\IntegrationsType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Customer extends Model
{
    protected $table;
    protected $guarded = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('xero.mapping.customers.table', 'customers');
    }
    public function xeroMapping(?int $merchant_id = null): MorphOne
    {
        return $this->morphOne(ThirdPartyMapping::class,'object')->where('type',IntegrationsType::Xero->value)->where('merchant_id',$merchant_id);
    }
    public function failSyncIntegrations(): MorphMany
    {
        return $this->morphMany(FailSyncIntegration::class, 'object');
    }
    public function thirdPartyMapping():MorphOne
    {
        return $this->morphOne(ThirdPartyMapping::class, 'object');
    }
}
