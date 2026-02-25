<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Refund extends BaseIntegrationModel
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
        return $this->hasMany(RefundItem::class,config('xero.mapping.refund_items.fields.refund_id', 'refund_id'));
    }

    public function client()
    {
        return $this->hasOneThrough(
            Customer::class,
            Invoice::class,
            'id', // 1. Foreign key on Invoices table (Invoice ID)
            'id', // 2. Foreign key on Customers table (Customer ID)
            config('xero.mapping.refunds.fields.invoice_id', 'invoice_id'), // 3. Local key on Refunds
            config('xero.mapping.invoices.fields.contact_id', 'contact_id')  // 4. Local key on Invoices (pointing to Customer)
        );
    }
    public function invoice():BelongsTo
    {
        return $this->belongsTo(Invoice::class, config('xero.mapping.refunds.fields.invoice_id', 'invoice_id'));
    }
}
