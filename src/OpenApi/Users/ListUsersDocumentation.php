<?php

declare(strict_types=1);

namespace App\OpenApi\Users;

use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/users',
    summary: 'Get stored user records',
    tags: ['Users'],
    security: [['ApiKeyAuth' => []]],
    parameters: [
        new OA\Parameter(
            name: 'sort',
            in: 'query',
            required: false,
            schema: new OA\Schema(
                type: 'string',
                enum: ['firstName', 'lastName', 'country', 'createdAt'],
                default: 'createdAt'
            )
        ),
        new OA\Parameter(
            name: 'order',
            in: 'query',
            required: false,
            schema: new OA\Schema(
                type: 'string',
                enum: ['asc', 'desc'],
                default: 'desc'
            )
        ),
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'List of stored user records',
            content: new OA\JsonContent(
                type: 'array',
                items: new OA\Items(ref: '#/components/schemas/UserRecord')
            )
        ),
        new OA\Response(response: 401, description: 'Unauthorized'),
    ]
)]
final class ListUsersDocumentation
{
}