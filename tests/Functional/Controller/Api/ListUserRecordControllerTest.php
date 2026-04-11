<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ListUserRecordControllerTest extends WebTestCase
{
    public function testListReturnsSuccess(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/users');

        self::assertResponseIsSuccessful();
    }
}