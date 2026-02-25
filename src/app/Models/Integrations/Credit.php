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

    public function customer()
    {
        return $this->belongsTo(Customer::class, config('xero.mapping.credits.fields.customer_id', 'customer_id'));
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class, config('xero.mapping.credits.fields.payment_id', 'payment_id'));
    }
}
