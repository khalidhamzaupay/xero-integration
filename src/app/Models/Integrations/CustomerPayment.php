<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends BaseIntegrationModel
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
//    public function customer()
//    {
//        return $this->hasOneThrough(Customer::class,
//            Invoice::class,
//            'id', // Foreign key on invoices table (mapped id)
//            'id', // Foreign key on customers table
//            'invoice_id', // Local key on customer_payments table
//            'contact_id'  // Local key on invoices table (mapped contact_id)
//        );
//    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
