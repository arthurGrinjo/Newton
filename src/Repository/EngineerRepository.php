<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Engineer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Engineer>
 * @method Engineer|null find($id, $lockMode = null, $lockVersion = null)
 * @method array<Engineer> findAll()
 * @method array<Engineer> findBy(mixed $criteria, mixed $orderBy = null, $limit = null, $offset = null)
 * @method Engineer|null findOneBy(mixed $criteria, mixed $orderBy = null)
 */
class EngineerRepository extends ServiceEntityRepository
{
    /** @use EntityRepository<Engineer> */
    use EntityRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Engineer::class);
    }
}