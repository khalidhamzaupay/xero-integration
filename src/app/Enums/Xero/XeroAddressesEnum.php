<?php

namespace App\Enums\Xero;

use App\Traits\BaseEnum;

enum XeroAddressesEnum: string
{
    use BaseEnum;

    case POBOX = "POBOX";  //The default mailing address for invoices
    case STREET = "STREET";
    case DELIVERY = "DELIVERY";
}
