<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Model>
 * @method Model|null find($id, $lockMode = null, $lockVersion = null)
 * @method array<Model> findAll()
 * @method array<Model> findBy(mixed $criteria, mixed $orderBy = null, $limit = null, $offset = null)
 * @method Model|null findOneBy(mixed $criteria, mixed $orderBy = null)
 */
class ModelRepository extends ServiceEntityRepository
{
    /** @use EntityRepository<Model> */
    use EntityRepository;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Model::class);
    }
}