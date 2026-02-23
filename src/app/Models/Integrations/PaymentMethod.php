<?php

namespace App\Models\Integrations;

use App\Enums\IntegrationsType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PaymentMethod extends BaseIntegrationModel
{
    protected $table;
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('xero.mapping.payment_methods.table', 'payment_methods');
    }
}
