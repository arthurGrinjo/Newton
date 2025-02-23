<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: BrandRepository::class)]
class Brand implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::STRING, length: 100, nullable: false)]
    private string $name;

    /**
     * @var Collection<int, SparePart>
     */
    #[ManyToMany(targetEntity: SparePart::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private Collection $spareParts;

    public function __construct(
        string $name,
    )
    {
        $this->uuid = Uuid::v6();
        $this->spareParts = new ArrayCollection();
        $this
            ->setName($name)
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