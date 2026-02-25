<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefundItem extends BaseIntegrationModel
{
    protected $table;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('xero.mapping.refund_items.table', 'refund_items');
    }

    public function refund():BelongsTo
    {
        return $this->belongsTo(Refund::class, config('xero.mapping.refund_items.fields.refund_id', 'refund_id'));
    }
    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class, config('xero.mapping.refund_items.fields.product_id', 'product_id'));
    }
}
