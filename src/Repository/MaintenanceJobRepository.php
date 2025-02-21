<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MaintenanceJob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MaintenanceJob>
 * @method MaintenanceJob|null find($id, $lockMode = null, $lockVersion = null)
 * @method array<MaintenanceJob> findAll()
 * @method array<MaintenanceJob> findBy(mixed $criteria, mixed $orderBy = null, $limit = null, $offset = null)
 * @method MaintenanceJob|null findOneBy(mixed $criteria, mixed $orderBy = null)
 */
class MaintenanceJobRepository extends ServiceEntityRepository
{
    /** @use EntityRepository<MaintenanceJob> */
    use EntityRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaintenanceJob::class);
    }
}