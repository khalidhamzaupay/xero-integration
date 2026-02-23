<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;

class RefundItem extends BaseIntegrationModel
{
    protected $table;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('xero.mapping.refund_items.table', 'refund_items');
    }
}
