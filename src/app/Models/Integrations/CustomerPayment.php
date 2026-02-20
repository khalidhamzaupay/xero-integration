<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    protected $table;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('xero.mapping.customer_payments.table', 'customer_payments');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
