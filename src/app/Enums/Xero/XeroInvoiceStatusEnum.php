<?php

namespace App\Enums\Xero;

use App\Traits\BaseEnum;

enum XeroInvoiceStatusEnum: string
{
    use BaseEnum;

    case ACTIVE = "ACTIVE";
    case AUTHORISED = "AUTHORISED";
    case POSTED = "POSTED";
}
