<?php

namespace App\Enums\Xero;

use App\Traits\BaseEnum;

enum XeroTaxTypesEnum: string
{
    use BaseEnum;

    case OUTPUT = "OUTPUT";
    case INPUT = "INPUT";
    case NONE = "NONE";
    case GSTONIMPORTS = "GSTONIMPORTS";
}
