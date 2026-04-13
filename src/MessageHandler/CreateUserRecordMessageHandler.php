<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\PhoneNumber;
use App\Entity\UserRecord;
use App\Interface\IpCountryResolverInterface;
use App\Message\CreateUserRecordMessage;
use App\Service\PhoneNumberNormalizer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateUserRecordMessageHandler
{
    public function __construct(
        private readonly IpCountryResolverInterface $resolver,
        private readonly PhoneNumberNormalizer $phoneNumberNormalizer,
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function __invoke(CreateUserRecordMessage $message): void
    {
        $country = $this->resolver->resolve($message->ipAddress);
        $normalizedPhones = $this->phoneNumberNormalizer->normalizeMany($message->phoneNumbers);

        if ($normalizedPhones === []) {
            throw new \InvalidArgumentException('No valid phone numbers');
        }

        $user = new UserRecord();
        $user->setFirstName($message->firstName);
        $user->setLastName($message->lastName);
        $user->setIpAddress($message->ipAddress);
        $user->setCountry($country);

        foreach ($normalizedPhones as $phoneValue) {
            $phone = new PhoneNumber();
            $phone->setPhoneNumber($phoneValue);
            $user->addPhoneNumber($phone);
        }

        $this->em->persist($user);
        $this->em->flush();
    }
}