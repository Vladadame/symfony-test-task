<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\PhoneNumber;
use App\Entity\UserRecord;
use App\Service\PhoneNumberNormalizer;

final class UserRecordFactory
{
    public function __construct(
        private readonly PhoneNumberNormalizer $phoneNumberNormalizer,
    ) {
    }

    public function create(
        string $firstName,
        string $lastName,
        string $ip,
        ?string $country,
        array $phones,
    ): UserRecord {
        $user = new UserRecord();
        $user->setFirstName(trim($firstName));
        $user->setLastName(trim($lastName));
        $user->setIpAddress($ip);
        $user->setCountry($country);

        $normalizedPhones = $this->phoneNumberNormalizer->normalizeMany($phones);

        if ($normalizedPhones === []) {
            throw new \InvalidArgumentException('No valid phone numbers');
        }

        foreach ($normalizedPhones as $phoneValue) {
            $phone = new PhoneNumber();
            $phone->setPhoneNumber($phoneValue);
            $user->addPhoneNumber($phone);
        }

        return $user;
    }
}