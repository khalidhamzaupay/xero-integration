<?php

namespace App\Enums\Xero;

use App\Traits\BaseEnum;

enum XeroOrganisationVersionTypesEnum: string
{
    use BaseEnum;

    case AU = "AU";
    case NZ = "NZ";
    case GLOBAL = "GLOBAL";
    case UK = "UK";
    case US = "US";
}
