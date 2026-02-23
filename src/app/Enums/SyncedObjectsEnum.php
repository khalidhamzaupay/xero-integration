<?php

namespace App\Enums;

use App\Models\Integrations\Credit;
use App\Models\Integrations\Customer;
use App\Models\Integrations\CustomerPayment;
use App\Models\Integrations\Invoice;
use App\Models\Integrations\Payment;
use App\Models\Integrations\Product;
use App\Models\Integrations\Refund;
use App\Traits\BaseEnum;

enum SyncedObjectsEnum: string
{
    use BaseEnum;


    case CUSTOMER = 'customer';
    case PRODUCT  = 'product';
    case INVOICE  = 'invoice';
    case PAYMENT  = 'payment';
    case CUSTOMER_PAYMENT  = 'customer_payment';
    case REFUND  = 'refund';
    case CREDIT  = 'credit';

    public function model(): string
    {
        return match ($this) {
            self::CUSTOMER => Customer::class,
            self::PRODUCT  => Product::class,
            self::INVOICE  => Invoice::class,
            self::PAYMENT  => Payment::class,
            self::CUSTOMER_PAYMENT  => CustomerPayment::class,
            self::REFUND  => Refund::class,
            self::CREDIT  => Credit::class,
        };
    }

}
