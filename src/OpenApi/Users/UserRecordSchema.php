<?php

declare(strict_types=1);

namespace App\OpenApi\Users;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UserRecord',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'firstName', type: 'string', example: 'Yura'),
        new OA\Property(property: 'lastName', type: 'string', example: 'Test'),
        new OA\Property(property: 'ipAddress', type: 'string', example: '127.0.0.1'),
        new OA\Property(property: 'country', type: 'string', nullable: true, example: 'Ukraine'),
        new OA\Property(
            property: 'phoneNumbers',
            type: 'array',
            items: new OA\Items(type: 'string'),
            example: ['+380971234567', '+380631234567']
        ),
        new OA\Property(
            property: 'createdAt',
            type: 'string',
            format: 'date-time',
            example: '2026-04-12T12:00:00+00:00'
        ),
    ]
)]
final class UserRecordSchema
{
}