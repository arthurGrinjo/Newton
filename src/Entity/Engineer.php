<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\EngineerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: EngineerRepository::class)]
class Engineer implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::STRING, length: 100, nullable: false)]
    private string $name;

    /**
     * @var Collection<int, ScheduledMaintenanceJob>
     */
    #[OneToMany(targetEntity: ScheduledMaintenanceJob::class, mappedBy: 'engineer')]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private Collection $scheduledMaintenanceJobs;

    public function __construct(
        string $name,
    ) {
        $this->uuid = Uuid::v6();
        $this->scheduledMaintenanceJobs = new ArrayCollection();
        $this
            ->setName($name)
        ;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Engineer
    {
        $this->name = $name;
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
}