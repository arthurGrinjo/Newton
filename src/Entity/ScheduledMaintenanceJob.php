<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\ScheduledMaintenanceJobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: ScheduledMaintenanceJobRepository::class)]
class ScheduledMaintenanceJob implements EntityInterface
{
    use IdentifiableEntity;

    #[ManyToOne(targetEntity: Engineer::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private Engineer $engineer;

    #[ManyToOne(targetEntity: MaintenanceJob::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private MaintenanceJob $maintenanceJob;

    #[ManyToOne(targetEntity: TimeSlot::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private TimeSlot $timeSlot;

    /**
     * @var Collection<int, Car>
     */
    #[ManyToMany(targetEntity: Car::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private Collection $cars;

    public function __construct(
        Engineer $engineer,
        TimeSlot $timeSlot,
        MaintenanceJob $maintenanceJob,
    ) {
        $this->uuid = Uuid::v6();
        $this->cars = new ArrayCollection();
        $this
            ->setEngineer($engineer)
            ->setTimeSlot($timeSlot)
            ->setMaintenanceJob($maintenanceJob)
        ;
    }

    public function getEngineer(): Engineer
    {
        return $this->engineer;
    }

    public function setEngineer(Engineer $engineer): self
    {
        $this->engineer = $engineer;
        return $this;
    }

    public function getMaintenanceJob(): MaintenanceJob
    {
        return $this->maintenanceJob;
    }

    public function setMaintenanceJob(MaintenanceJob $maintenanceJob): self
    {
        $this->maintenanceJob = $maintenanceJob;
        return $this;
    }

    public function getTimeSlot(): TimeSlot
    {
        return $this->timeSlot;
    }

    public function setTimeSlot(TimeSlot $timeSlot): self
    {
        $this->timeSlot = $timeSlot;
        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function setCars(Car ...$cars): self
    {
        $this->cars = new ArrayCollection();
        foreach ($cars as $car) {
            $this->addCar($car);
        }
        return $this;
    }

    public function addCar(Car $car): self
    {
        if ($this->cars->contains($car) === false) {
            $this->cars->add($car);
        }
        return $this;
    }
}