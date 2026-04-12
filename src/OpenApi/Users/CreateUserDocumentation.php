<?php

declare(strict_types=1);

namespace App\OpenApi\Users;

use OpenApi\Attributes as OA;

#[OA\Post(
    path: '/api/users',
    summary: 'Accept user record for asynchronous processing',
    tags: ['Users'],
    security: [['ApiKeyAuth' => []]],
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['firstName', 'lastName', 'phoneNumbers'],
            properties: [
                new OA\Property(property: 'firstName', type: 'string', example: 'Yura'),
                new OA\Property(property: 'lastName', type: 'string', example: 'Test'),
                new OA\Property(
                    property: 'phoneNumbers',
                    type: 'array',
                    items: new OA\Items(type: 'string'),
                    example: ['+380971234567', '+380631234567']
                ),
            ]
        )
    ),
    responses: [
        new OA\Response(response: 202, description: 'Accepted for processing'),
        new OA\Response(response: 400, description: 'Invalid JSON payload'),
        new OA\Response(response: 422, description: 'Validation failed'),
        new OA\Response(response: 401, description: 'Unauthorized'),
    ]
)]
final class CreateUserDocumentation
{
}