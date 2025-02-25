<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ScheduledMaintenanceJob;
use DateTimeImmutable;
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

    /**
     * @return array<int, array{id: int, date: DateTimeImmutable, start: int, end: int}>
     */
    public function getEarliestJobAndEngineer(int $limit): array
    {
        $rootAlias = 'job';
        $timeSlotAlias = 'timeSlot';
        $engineerAlias = 'engineer';

        $queryBuilder = $this->createQueryBuilder($rootAlias);
        $queryBuilder
            ->innerJoin(sprintf('%s.engineer', $rootAlias), $engineerAlias)
            ->innerJoin(sprintf("%s.%s", $rootAlias, $timeSlotAlias), $timeSlotAlias)
            ->select(sprintf('%s.id', $engineerAlias))
            ->addSelect(sprintf('%1$s.date, MAX(%1$s.start) as start, MAX(%1$s.end) AS end', $timeSlotAlias))
            ->groupBy(sprintf('%s.date', $timeSlotAlias))
            ->addGroupBy(sprintf('%s.id', $engineerAlias))
            ->orderBy(sprintf('%s.date', $timeSlotAlias), 'DESC')
            ->addOrderBy('end', 'DESC')
            ->setMaxResults($limit)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}