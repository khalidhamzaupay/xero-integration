<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Integrations\PaymentMethod as IntegrationPaymentMethod;

class UpayPaymentMethodModel extends Model
{
    protected $table = 'paymentmethods';
    protected $guarded = [];


}
