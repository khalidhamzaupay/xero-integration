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
        return $this->hasMany(InvoiceItem::class);
    }
    public function client():BelongsTo
    {
        return $this->belongsTo(Customer::class, 'contact_id');
    }
}
