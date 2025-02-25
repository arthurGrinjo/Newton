<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\TimeSlot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TimeSlot>
 * @method TimeSlot|null find($id, $lockMode = null, $lockVersion = null)
 * @method array<TimeSlot> findAll()
 * @method array<TimeSlot> findBy(mixed $criteria, mixed $orderBy = null, $limit = null, $offset = null)
 * @method TimeSlot|null findOneBy(mixed $criteria, mixed $orderBy = null)
 */
class TimeSlotRepository extends ServiceEntityRepository
{
    /** @use EntityRepository<TimeSlot> */
    use EntityRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeSlot::class);
    }
}