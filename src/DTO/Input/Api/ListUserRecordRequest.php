<?php

declare(strict_types=1);

namespace App\DTO\Input\Api;

use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\Api\SortOrder;
use App\Enum\Api\UserSortField;

final class ListUserRecordRequest
{
    public function __construct(
        public readonly UserSortField $sort = UserSortField::CREATED_AT,
        public readonly SortOrder $order = SortOrder::DESC,
    ) {
    }
}