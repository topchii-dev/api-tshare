<?php

declare(strict_types=1);

namespace App\Models\Enum\UserEnum;

enum UserRolesEnum: string
{
    case Admin = 'admin';
    case User = 'user';
}
