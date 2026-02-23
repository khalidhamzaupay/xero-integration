<?php

namespace App\Models\Integrations;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends BaseIntegrationModel
{
    protected $table;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('xero.mapping.products.table', 'products');
    }
    public function merchant():BelongsTo
    {
        return $this->belongsTo(
            Merchant::class,
            config('xero.mapping.products.fields.merchant_id', 'merchant_id'),
            'id'
        );
//        return $this->belongsTo(Merchant::class);
    }

}
