<?php

declare(strict_types=1);

namespace App\Service;

final class PhoneNumberNormalizer
{
    /**
     * @param array $phones
     * @return string[]
     */
    public function normalizeMany(array $phones): array
    {
        $result = [];

        foreach ($phones as $phone) {
            if (!is_string($phone)) {
                continue;
            }

            $phone = trim($phone);

            if ($phone === '') {
                continue;
            }

            if (!preg_match('/^\+?[0-9()\-\s]+$/', $phone)) {
                continue;
            }

            $result[] = $phone;
        }

        return array_values(array_unique($result));
    }
}