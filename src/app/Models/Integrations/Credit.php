<?php

namespace App\Models\Integrations;


class Credit extends BaseIntegrationModel
{
    protected $table;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('xero.mapping.credits.table', 'credits');
    }

    public function client()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
