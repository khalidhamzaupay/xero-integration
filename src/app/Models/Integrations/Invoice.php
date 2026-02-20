<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
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
}
