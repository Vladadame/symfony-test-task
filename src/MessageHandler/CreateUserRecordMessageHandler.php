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
        $country = $this->resolver->resolve($message->ipAddress);

        $userRecord = $this->factory->create(
            $message->firstName,
            $message->lastName,
            $message->ipAddress,
            $country,
            $message->phoneNumbers,
        );

        $this->em->persist($userRecord);
        $this->em->flush();
    }
}