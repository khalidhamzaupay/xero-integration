<?php

namespace App\Enums\Xero;

use App\Traits\BaseEnum;

enum XeroContactStatusEnum: string
{
    use BaseEnum;

    case ACTIVE = "ACTIVE";
    case ARCHIVED = "ARCHIVED";
    case GDPRREQUEST = "GDPRREQUEST";
}
