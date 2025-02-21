<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\ModelRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: ModelRepository::class)]
class Model implements EntityInterface
{
    use IdentifiableEntity;

    #[ManyToOne(targetEntity: Brand::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private Brand $brand;

    #[ManyToOne(targetEntity: Car::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private ?Car $car;

    public function __construct(
        Brand $brand,
        Car $car,
    ) {
        $this->uuid = Uuid::v6();
        $this
            ->setBrand($brand)
            ->setCar($car)
        ;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;
        return $this;
    }
}