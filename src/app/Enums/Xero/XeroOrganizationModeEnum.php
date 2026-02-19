<?php

namespace App\Enums\Xero;

use App\Traits\BaseEnum;

enum XeroOrganizationModeEnum: string
{
    use BaseEnum;

    case LIVE = "Live";
    case DEMO = "Demo";
}
