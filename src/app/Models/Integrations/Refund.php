<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $table;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('xero.mapping.refunds.table', 'refunds');
    }

    public function items()
    {
        return $this->hasMany(RefundItem::class);
    }
}
