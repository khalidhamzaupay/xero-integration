<?php

namespace App\Enums\Xero;

use App\Traits\BaseEnum;

enum XeroPhoneTypesEnum: string
{
    use BaseEnum;

    case DEFAULT = "DEFAULT";
    case DDI = "DDI";
    case MOBILE = "MOBILE";
    case FAX = "FAX";
}
