<?php

namespace App\Enums;

use App\Traits\BaseEnum;

enum ThirdPartySyncProcessTypeEnum: int
{
    use BaseEnum;


    case GET = 0;
    case CREATE = 1;
    case UPDATE = 2;
    case DELETE = 3;
    case VOID = 4;
    public function getLabel(): string
    {
        return match ($this) {
            ThirdPartySyncProcessTypeEnum::GET => 'Get',
            ThirdPartySyncProcessTypeEnum::CREATE => 'Create',
            ThirdPartySyncProcessTypeEnum::UPDATE => 'Update',
            ThirdPartySyncProcessTypeEnum::DELETE => 'Delete',
            ThirdPartySyncProcessTypeEnum::VOID => 'Void',
        };
    }

    public static function fromLabel(string $label): ?ThirdPartySyncProcessTypeEnum
    {
        return match ($label) {
            'Get' => ThirdPartySyncProcessTypeEnum::GET,
            'Create' => ThirdPartySyncProcessTypeEnum::CREATE,
            'Update' => ThirdPartySyncProcessTypeEnum::UPDATE,
            'Void' => ThirdPartySyncProcessTypeEnum::VOID,
            default => ThirdPartySyncProcessTypeEnum::DELETE,
        };
    }

}
