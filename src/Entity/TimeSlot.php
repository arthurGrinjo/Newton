<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\TimeSlotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: TimeSlotRepository::class)]
class TimeSlot implements EntityInterface
{
    use IdentifiableEntity;

    /**
     * @var Collection<int, ScheduledMaintenanceJob>
     */
    #[OneToMany(targetEntity: ScheduledMaintenanceJob::class, mappedBy: 'timeslot')]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private Collection $scheduledMaintenanceJobs;

    public function __construct()
    {
        $this->uuid = Uuid::v6();
        $this->scheduledMaintenanceJobs = new ArrayCollection();
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
}