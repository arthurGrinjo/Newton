<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: BrandRepository::class)]
class Brand implements EntityInterface
{
    use IdentifiableEntity;

    /**
     * @var Collection<int, SparePart>
     */
    #[ManyToMany(targetEntity: SparePart::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private Collection $spareParts;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->spareParts = new ArrayCollection();
    }

    /**
     * @return Collection<int, SparePart>
     */
    public function getSpareParts(): Collection
    {
        return $this->spareParts;
    }

    public function setSpareParts(SparePart ...$spareParts): self
    {
        $this->spareParts = new ArrayCollection();
        foreach ($spareParts as $sparePart) {
            $this->addSparePart($sparePart);
        }
        return $this;
    }

    public function addSparePart(SparePart $sparePart): self
    {
        if ($this->spareParts->contains($sparePart) === false) {
            $this->spareParts->add($sparePart);
        }
        return $this;
    }
}