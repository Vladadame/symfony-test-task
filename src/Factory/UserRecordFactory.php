<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\PhoneNumber;
use App\Entity\UserRecord;

final class UserRecordFactory
{
    public function create(
        string $firstName,
        string $lastName,
        string $ip,
        ?string $country,
        array $phones,
    ): UserRecord {
        $user = new UserRecord();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setIpAddress($ip);
        $user->setCountry($country);

        foreach ($phones as $p) {
            $phone = new PhoneNumber();
            $phone->setPhoneNumber($p);
            $user->addPhoneNumber($phone);
        }

        return $user;
    }
}