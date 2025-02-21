<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ScheduledMaintenanceJob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ScheduledMaintenanceJob>
 * @method ScheduledMaintenanceJob|null find($id, $lockMode = null, $lockVersion = null)
 * @method array<ScheduledMaintenanceJob> findAll()
 * @method array<ScheduledMaintenanceJob> findBy(mixed $criteria, mixed $orderBy = null, $limit = null, $offset = null)
 * @method ScheduledMaintenanceJob|null findOneBy(mixed $criteria, mixed $orderBy = null)
 */
class ScheduledMaintenanceJobRepository extends ServiceEntityRepository
{
    /** @use EntityRepository<ScheduledMaintenanceJob> */
    use EntityRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScheduledMaintenanceJob::class);
    }
}