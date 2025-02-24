<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\SparePartRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
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

    /**
     * @var Collection<int, Brand>
     */
    #[ManyToMany(targetEntity: Brand::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private Collection $brands;

    public function __construct(
        string $name,
        int $price,
    ) {
        $this->uuid = Uuid::v6();
        $this->brands = new ArrayCollection();
        $this
            ->setName($name)
            ->setPrice($price)
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

    /**
     * @return Collection<int, Brand>
     */
    public function getBrands(): Collection
    {
        return $this->brands;
    }

    public function setBrands(Brand ...$brands): self
    {
        $this->brands = new ArrayCollection();
        foreach ($brands as $brand) {
            $this->addBrand($brand);
        }
        return $this;
    }

    public function addBrand(Brand $brand): self
    {
        if ($this->brands->contains($brand) === false) {
            $this->brands->add($brand);
        }
        return $this;
    }
}