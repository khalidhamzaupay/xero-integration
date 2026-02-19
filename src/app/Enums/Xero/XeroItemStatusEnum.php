<?php

namespace App\Enums\Xero;

use App\Traits\BaseEnum;

enum XeroItemStatusEnum: string
{
    use BaseEnum;

    case ACTIVE = "ACTIVE";
    case ARCHIVED = "ARCHIVED";
}
