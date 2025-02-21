<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: CustomerRepository::class)]
class Customer implements EntityInterface
{
    use IdentifiableEntity;

    #[ManyToOne(targetEntity: Car::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private Car $car;

    public function __construct(
        Car $car,
    ) {
        $this->uuid = Uuid::v6();
        $this->setCar($car);
    }

    public function getCar(): Car
    {
        return $this->car;
    }

    public function setCar(Car $car): self
    {
        $this->car = $car;
        return $this;
    }
}