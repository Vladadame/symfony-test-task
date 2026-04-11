<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CreateUserRecordControllerTest extends WebTestCase
{
    public function testCreateReturnsAcceptedForValidPayload(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/users',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'firstName' => 'Yura',
                'lastName' => 'Test',
                'phoneNumbers' => ['+380971234567'],
            ], JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(202);
    }

    public function testCreateReturnsValidationErrorForInvalidPayload(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/users',
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode([
                'firstName' => '',
                'lastName' => '',
                'phoneNumbers' => [],
            ], JSON_THROW_ON_ERROR)
        );

        self::assertResponseStatusCodeSame(422);
    }
}