<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\ModelRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: ModelRepository::class)]
class Model implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::STRING, length: 100, nullable: false)]
    private string $name;

    #[ManyToOne(targetEntity: Brand::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private Brand $brand;

    #[ManyToOne(targetEntity: Car::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private ?Car $car;

    public function __construct(
        string $name,
        Brand $brand,
        Car $car,
    ) {
        $this->uuid = Uuid::v6();
        $this
            ->setName($name)
            ->setBrand($brand)
            ->setCar($car)
        ;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
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