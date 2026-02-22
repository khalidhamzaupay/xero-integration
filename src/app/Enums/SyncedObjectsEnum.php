<?php

namespace App\Enums;

use App\Models\Integrations\Customer;
use App\Traits\BaseEnum;

enum SyncedObjectsEnum: string
{
    use BaseEnum;


    case CUSTOMER = 'customer';
    case PRODUCT  = 'product';
    case INVOICE  = 'invoice';

    public function model(): string
    {
        return match ($this) {
            self::CUSTOMER => Customer::class,
//            self::PRODUCT  => Product::class,
//            self::INVOICE  => Invoice::class,
        };
    }

}
