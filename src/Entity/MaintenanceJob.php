<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\MaintenanceJobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: MaintenanceJobRepository::class)]
class MaintenanceJob implements EntityInterface
{
    use IdentifiableEntity;

    /**
     * @var Collection<int, ScheduledMaintenanceJob>
     */
    #[OneToMany(targetEntity: ScheduledMaintenanceJob::class, mappedBy: 'maintenanceJob')]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private Collection $scheduledMaintenanceJobs;

    /**
     * @var Collection<int, SparePart>
     */
    #[ManyToMany(targetEntity: SparePart::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private Collection $spareParts;

    public function __construct() {
        $this->uuid = Uuid::v6();
        $this->scheduledMaintenanceJobs = new ArrayCollection();
        $this->spareParts = new ArrayCollection();
    }

    /**
     * @return Collection<int, ScheduledMaintenanceJob>
     */
    public function getScheduledMaintenanceJobs(): Collection
    {
        return $this->scheduledMaintenanceJobs;
    }

    public function setScheduledMaintenanceJobs(ScheduledMaintenanceJob ...$scheduledMaintenanceJobs): self
    {
        $this->scheduledMaintenanceJobs = new ArrayCollection();
        foreach ($scheduledMaintenanceJobs as $scheduledMaintenanceJob) {
            $this->addScheduledMaintenanceJob($scheduledMaintenanceJob);
        }
        return $this;
    }

    public function addScheduledMaintenanceJob(ScheduledMaintenanceJob $scheduledMaintenanceJob): self
    {
        $this->scheduledMaintenanceJobs->add($scheduledMaintenanceJob);
        return $this;
    }

    public function removeScheduledMaintenanceJob(ScheduledMaintenanceJob $scheduledMaintenanceJob): self
    {
        $this->scheduledMaintenanceJobs->removeElement($scheduledMaintenanceJob);
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