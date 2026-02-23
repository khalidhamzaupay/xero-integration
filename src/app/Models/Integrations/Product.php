<?php

namespace App\Models\Integrations;

class Product extends BaseIntegrationModel
{
    protected $table;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('xero.mapping.products.table', 'products');
    }


}
