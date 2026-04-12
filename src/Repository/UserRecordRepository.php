<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\DTO\Output\Api\UserRecordModel;
use App\DTO\Input\Api\ListUserRecordRequest;
use App\Entity\PhoneNumber;


/**
 * @extends ServiceEntityRepository<UserRecord>
 */
final class UserRecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserRecord::class);
    }

    /**
     * @return UserRecordModel[]
     */
    public function findSorted(ListUserRecordRequest $request): array
    {
        $records = $this->createQueryBuilder('u')
            ->leftJoin('u.phoneNumbers', 'p')
            ->addSelect('p')
            ->orderBy('u.' . $request->sort->value, $request->order->value)
            ->getQuery()
            ->getResult();
            
        return array_map(
        static fn (UserRecord $user): UserRecordModel => new UserRecordModel(
            $user->getId(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getIpAddress(),
            $user->getCountry() ?? '',
            phoneNumbers: array_map(
                static fn (PhoneNumber $phone): string => $phone->getPhoneNumber(),
                $user->getPhoneNumbers()->toArray()
            ),
            createdAt: $user->getCreatedAt(),
        ),
        $records
    );
            
    }
}