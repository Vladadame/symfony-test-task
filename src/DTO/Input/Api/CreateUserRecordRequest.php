<?php

declare(strict_types=1);

namespace App\DTO\Input\Api;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateUserRecordRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(max: 255)]
        public readonly string $firstName,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        #[Assert\Length(max: 255)]
        public readonly string $lastName,

        #[Assert\NotNull]
        #[Assert\Type('array')]
        #[Assert\Count(min: 1)]
        #[Assert\All([
            new Assert\NotBlank(),
            new Assert\Type('string'),
            new Assert\Length(max: 30),
            new Assert\Regex('/^\+?[0-9()\-\s]+$/'),
        ])]
        public readonly array $phoneNumbers,
    ) {
    }
}