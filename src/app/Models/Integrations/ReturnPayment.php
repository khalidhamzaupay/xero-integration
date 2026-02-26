<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;

class ReturnPayment extends BaseIntegrationModel
{
    protected $table;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('xero.mapping.return_payments.table', 'return_payments');
    }

    public function refund()
    {
        return $this->belongsTo(Refund::class, config('xero.mapping.return_payments.fields.refund_id', 'refund_id'));
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, config('xero.mapping.return_payments.fields.customer_id', 'customer_id'));
    }
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, config('xero.mapping.return_payments.fields.payment_method_id', 'payment_method_id'));
    }
}
