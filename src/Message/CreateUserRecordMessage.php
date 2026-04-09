<?php

declare(strict_types=1);

namespace App\Message;

final readonly class CreateUserRecordMessage
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public array $phoneNumbers,
        public string $ipAddress,
    ) {}
}