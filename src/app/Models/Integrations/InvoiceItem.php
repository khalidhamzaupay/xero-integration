<?php


namespace App\Models\Integrations;


use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends BaseIntegrationModel
{
    protected $table;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('xero.mapping.invoice_items.table', 'invoice_items');
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class, config('xero.mapping.invoice_items.fields.product_id', 'product_id'));
    }
    public function invoice():BelongsTo
    {
        return $this->belongsTo(Invoice::class, config('xero.mapping.invoice_items.fields.invoice_id', 'invoice_id'));
    }

}
