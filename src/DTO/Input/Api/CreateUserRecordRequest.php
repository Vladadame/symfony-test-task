<?php

declare(strict_types=1);

namespace App\DTO\Input\Api;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateUserRecordRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public readonly string $firstName;

    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    public readonly string $lastName;

    #[Assert\NotNull]
    #[Assert\Count(min: 1)]
    #[Assert\All([
        new Assert\NotBlank(),
        new Assert\Type('string'),
        new Assert\Length(max: 30),
        new Assert\Regex('/^\+?[0-9()\-\s]+$/'),
    ])]
    public readonly array $phoneNumbers;

    public function __construct(
        string $firstName,
        string $lastName,
        array $phoneNumbers,
    ) {
        $this->firstName = trim($firstName);
        $this->lastName = trim($lastName);

        $this->phoneNumbers = array_map(
            static fn ($phone) => is_string($phone) ? trim($phone) : $phone,
            $phoneNumbers
        );
    }
}