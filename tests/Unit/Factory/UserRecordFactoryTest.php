<?php

declare(strict_types=1);

namespace App\Tests\Unit\Factory;

use App\Factory\UserRecordFactory;
use PHPUnit\Framework\TestCase;

final class UserRecordFactoryTest extends TestCase
{
    public function testCreateBuildsUserRecordWithPhoneNumbers(): void
    {
        $factory = new UserRecordFactory();

        $userRecord = $factory->create(
            'Yura',
            'Test',
            '127.0.0.1',
            'Ukraine',
            ['+380971234567', '+380631234567']
        );

        self::assertSame('Yura', $userRecord->getFirstName());
        self::assertSame('Test', $userRecord->getLastName());
        self::assertSame('127.0.0.1', $userRecord->getIpAddress());
        self::assertSame('Ukraine', $userRecord->getCountry());
        self::assertCount(2, $userRecord->getPhoneNumbers());
    }
}