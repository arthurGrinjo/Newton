<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Brand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Brand>
 * @method Brand|null find($id, $lockMode = null, $lockVersion = null)
 * @method array<Brand> findAll()
 * @method array<Brand> findBy(mixed $criteria, mixed $orderBy = null, $limit = null, $offset = null)
 * @method Brand|null findOneBy(mixed $criteria, mixed $orderBy = null)
 */
class BrandRepository extends ServiceEntityRepository
{
    /** @use EntityRepository<Brand> */
    use EntityRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brand::class);
    }
}