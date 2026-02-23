<?php

namespace App\Models\Integrations;

use App\Enums\IntegrationsType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Merchant extends Model
{
    protected $table;
    protected $guarded = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('xero.mapping.merchants.table', 'users');
    }

    public function xeroThirdPartyAccess():HasOne
    {
        return $this->hasOne(ThirdPartyAccess::class)->where('type',IntegrationsType::Xero->value);
    }


}
