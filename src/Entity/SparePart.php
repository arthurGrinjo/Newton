<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\SparePartRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: SparePartRepository::class)]
class SparePart implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::STRING, length: 100, nullable: false)]
    private string $name;

    // price in cents
    #[Column(type: Types::INTEGER, nullable: false)]
    private int $price;

    #[ManyToOne(targetEntity: Brand::class, cascade: ['persist'], inversedBy: 'spare_parts')]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private Brand $brand;

    public function __construct(
        string $name,
        int $price,
        Brand $brand
    ) {
        $this->uuid = Uuid::v6();
        $this
            ->setName($name)
            ->setPrice($price)
            ->setBrand($brand)
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

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand): SparePart
    {
        $this->brand = $brand;
        return $this;
    }
}