<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method array<Car> findAll()
 * @method array<Car> findBy(mixed $criteria, mixed $orderBy = null, $limit = null, $offset = null)
 * @method Car|null findOneBy(mixed $criteria, mixed $orderBy = null)
 */
class CarRepository extends ServiceEntityRepository
{
    /** @use EntityRepository<Car> */
    use EntityRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }
}