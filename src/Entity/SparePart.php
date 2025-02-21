<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\SparePartRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: SparePartRepository::class)]
class SparePart implements EntityInterface
{
    use IdentifiableEntity;

    /**
     * @var Collection<int, MaintenanceJob>
     */
    #[ManyToMany(targetEntity: MaintenanceJob::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private Collection $maintenanceJobs;

    /**
     * @var Collection<int, Brand>
     */
    #[ManyToMany(targetEntity: Brand::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private Collection $brands;

    public function __construct() {
        $this->uuid = Uuid::v6();
        $this->maintenanceJobs = new ArrayCollection();
        $this->brands = new ArrayCollection();
    }

    /**
     * @return Collection<int, MaintenanceJob>
     */
    public function getMaintenanceJobs(): Collection
    {
        return $this->maintenanceJobs;
    }

    public function setMaintenanceJobs(MaintenanceJob ...$maintenanceJobs): self
    {
        $this->maintenanceJobs = new ArrayCollection();
        foreach ($maintenanceJobs as $maintenanceJob) {
            $this->addMaintenanceJob($maintenanceJob);
        }
        return $this;
    }

    public function addMaintenanceJob(MaintenanceJob $maintenanceJob): self
    {
        if ($this->maintenanceJobs->contains($maintenanceJob) === false) {
            $this->maintenanceJobs->add($maintenanceJob);
        }
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