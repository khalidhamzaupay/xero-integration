<?php

namespace App\Models\Integrations;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends BaseIntegrationModel
{
    protected $table;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('xero.mapping.invoices.table', 'invoices');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class,config('xero.mapping.invoice_items.fields.invoice_id', 'invoice_id'));
    }
    public function refunds()
    {
        return $this->hasMany(Refund::class,config('xero.mapping.refunds.fields.invoice_id', 'invoice_id'));
    }
    public function client():BelongsTo
    {
        return $this->belongsTo(Customer::class, config('xero.mapping.invoices.fields.contact_id', 'contact_id'));
    }
    public function merchant():BelongsTo
    {
        return $this->belongsTo(
            Merchant::class, config('xero.mapping.invoices.fields.merchant_id', 'merchant_id'),
            'id'
        );
    }
}
