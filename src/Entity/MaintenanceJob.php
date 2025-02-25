<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\MaintenanceJobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: MaintenanceJobRepository::class)]
class MaintenanceJob implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::STRING, length: 100, nullable: false)]
    private string $task;

    // time in quarters
    #[Column(type: Types::INTEGER, nullable: false)]
    private int $duration;

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

    public function __construct(
        string $task,
        int $duration,
    ) {
        $this->uuid = Uuid::v6();
        $this->scheduledMaintenanceJobs = new ArrayCollection();
        $this->spareParts = new ArrayCollection();
        $this
            ->setTask($task)
            ->setDuration($duration)
        ;
    }

    public function getTask(): string
    {
        return $this->task;
    }

    public function setTask(string $task): self
    {
        $this->task = $task;
        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
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

    /**
     * @param array<SparePart> $spareParts
     */
    public function setSpareParts(array $spareParts): self
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