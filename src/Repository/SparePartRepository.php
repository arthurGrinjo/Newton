<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Car;
use App\Entity\SparePart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SparePart>
 * @method SparePart|null find($id, $lockMode = null, $lockVersion = null)
 * @method array<SparePart> findAll()
 * @method array<SparePart> findBy(mixed $criteria, mixed $orderBy = null, $limit = null, $offset = null)
 * @method SparePart|null findOneBy(mixed $criteria, mixed $orderBy = null)
 */
class SparePartRepository extends ServiceEntityRepository
{
    /** @use EntityRepository<SparePart> */
    use EntityRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SparePart::class);
    }
}