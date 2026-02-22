<?php

namespace App\Models\Integrations;

use App\Enums\IntegrationsType;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Customer extends BaseIntegrationModel
{
    protected $table;
    protected $guarded = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config('xero.mapping.customers.table', 'customers');
    }

}
