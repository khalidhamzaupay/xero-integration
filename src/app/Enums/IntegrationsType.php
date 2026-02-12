<?php

namespace App\Enums;

use App\Traits\BaseEnum;

enum IntegrationsType: string
{
    use BaseEnum;


    case Xero = 'xero';

}
