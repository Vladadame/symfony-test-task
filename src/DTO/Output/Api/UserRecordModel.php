<?php

declare(strict_types=1);

namespace App\DTO\Output\Api;

final class UserRecordModel
{
    public function __construct(
        public int $id,
        public string $firstName,
        public string $lastName,
        public string $ipAddress,
        public ?string $country,
        public array $phoneNumbers,
        private \DateTimeImmutable $createdAt,
    ) {
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt->format(DATE_ATOM);
    }
}