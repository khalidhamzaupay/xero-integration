<?php

namespace App\Enums\Xero;

use App\Traits\BaseEnum;

enum XeroLineAmountTypesEnum: string
{
    use BaseEnum;

    case EXCLUSIVE = "Exclusive";
    case INCLUSIVE = "Inclusive";
    case NOTAX = "NoTax";
}
