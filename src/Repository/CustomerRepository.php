<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Customer>
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method array<Customer> findAll()
 * @method array<Customer> findBy(mixed $criteria, mixed $orderBy = null, $limit = null, $offset = null)
 * @method Customer|null findOneBy(mixed $criteria, mixed $orderBy = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    /** @use EntityRepository<Customer> */
    use EntityRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * @return array<int, Customer>
     */
    public function findCustomerByName(string $search): array
    {
        $alias = 'customer';

        $queryBuilder = $this->createQueryBuilder($alias);
        $queryBuilder
            ->select()
            ->where(
                $queryBuilder->expr()->like(sprintf('%s.name', $alias), ':search')
            )
            ->setParameter('search', sprintf('%%%s%%', $search))
            ->setMaxResults(5)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}