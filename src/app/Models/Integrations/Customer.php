<?php

namespace App\Models\Integrations;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table;
    protected $guarded = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('xero.mapping.customers.table', 'customers');
    }

}
