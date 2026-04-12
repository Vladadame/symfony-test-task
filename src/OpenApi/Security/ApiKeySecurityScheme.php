<?php

declare(strict_types=1);

namespace App\OpenApi\Security;

use OpenApi\Attributes as OA;

#[OA\SecurityScheme(
    securityScheme: 'ApiKeyAuth',
    type: 'apiKey',
    in: 'header',
    name: 'X-API-Key'
)]
final class ApiKeySecurityScheme
{
}