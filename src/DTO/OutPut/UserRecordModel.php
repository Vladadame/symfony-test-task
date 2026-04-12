<?php

declare(strict_types=1);

namespace App\DTO\OutPut;

class UserRecordModel 

{
    
    public function __construct(
        public int $id,
        public string $firstname,
        public string $lastname,
        public string $ipAddress,
        public string $country,
        public array $phoneNumbers,
        private \DateTimeImmutable $createdAt,
    ) {}
    public function getCreatedAt(): string{
        return $this->createdAt->format(DATE_ATOM);
    }
    
}