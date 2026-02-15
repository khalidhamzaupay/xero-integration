<?php

namespace App\Enums;

use App\Traits\BaseEnum;

enum ThirdPartyAccessStateEnum: string
{
    use BaseEnum;


    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

}
