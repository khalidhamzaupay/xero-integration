<?php

namespace App\Enums;

use App\Traits\BaseEnum;

enum SyncIntegrationStatusEnum: string
{
    use BaseEnum;


    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAIL = 'fail';

}
