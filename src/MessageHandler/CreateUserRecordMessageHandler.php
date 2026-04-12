<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Factory\UserRecordFactory;
use App\Message\CreateUserRecordMessage;
use App\Service\IpCountryResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateUserRecordMessageHandler
{
    public function __construct(
        private readonly IpCountryResolverInterface $resolver,
        private readonly UserRecordFactory $factory,
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function __invoke(CreateUserRecordMessage $message): void
    {
        if (trim($message->firstName) === '' || trim($message->lastName) === '') {
            throw new \InvalidArgumentException('Invalid name');
        }

        foreach ($message->phoneNumbers as $phoneNumber) {
            if (!is_string($phoneNumber) || trim($phoneNumber) === '') {
                throw new \InvalidArgumentException('Invalid phone number');
            }
        }

        $country = $this->resolver->resolve($message->ipAddress) ?? null;

        $userRecord = $this->factory->create(
            firstName: trim($message->firstName),
            lastName: trim($message->lastName),
            ipAddress: $message->ipAddress,
            country: $country,
            phoneNumbers: $message->phoneNumbers,
        );

        $this->em->persist($userRecord);
        $this->em->flush();
    }
}