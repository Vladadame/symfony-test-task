<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\UserRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
     * @return UserRecord[]
     */
    public function findSorted(string $sort, string $order): array
    {
        $allowedSortFields = [
            'firstName' => 'u.firstName',
            'lastName' => 'u.lastName',
            'country' => 'u.country',
            'createdAt' => 'u.createdAt',
        ];

        $sortField = $allowedSortFields[$sort] ?? $allowedSortFields['createdAt'];
        $direction = strtolower($order) === 'asc' ? 'ASC' : 'DESC';

        return $this->createQueryBuilder('u')
            ->leftJoin('u.phoneNumbers', 'p')
            ->addSelect('p')
            ->orderBy($sortField, $direction)
            ->getQuery()
            ->getResult();
    }
}