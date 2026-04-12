<?php

declare(strict_types=1);

namespace App\Enum\Api;
enum UserSortField: string
{
    case FIRST_NAME = 'firstName';
    case LAST_NAME = 'lastName';
    case COUNTRY = 'country';
    case CREATED_AT = 'createdAt';
}