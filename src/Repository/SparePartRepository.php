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

    public function getSparePartPrice(SparePart $sparePart, Car $car): int
    {
        $rootAlias = 'sparepart';

        $queryBuilder = $this->createQueryBuilder($rootAlias);
        $queryBuilder

            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq(sprintf('%s.id', $rootAlias), ':spare_part_id'),
                )
            )
            ->setParameter('spare_part_id', $sparePart->getId())
            ->setMaxResults(1)
        ;

        /** @var array<int, SparePart> $result */
        $result = $queryBuilder->getQuery()->getResult();

        return ($result === null)
            ? 0
            : $result[0]->getPrice();
    }
}