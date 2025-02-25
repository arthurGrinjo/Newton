<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\ScheduledMaintenanceJobRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: ScheduledMaintenanceJobRepository::class)]
class ScheduledMaintenanceJob implements EntityInterface
{
    use IdentifiableEntity;

    #[ManyToOne(targetEntity: Engineer::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private Engineer $engineer;

    #[ManyToOne(targetEntity: MaintenanceJob::class, cascade: ['persist'])]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private MaintenanceJob $maintenanceJob;

    #[ManyToOne(targetEntity: TimeSlot::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private TimeSlot $timeSlot;

    #[ManyToOne(targetEntity: Car::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: true)]
    private Car $car;

    public function __construct(
        Engineer $engineer,
        TimeSlot $timeSlot,
        MaintenanceJob $maintenanceJob,
        Car $car,
    ) {
        $this->uuid = Uuid::v6();
        $this
            ->setEngineer($engineer)
            ->setTimeSlot($timeSlot)
            ->setMaintenanceJob($maintenanceJob)
            ->setCar($car)
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

    public function getCar(): Car
    {
        return $this->car;
    }

    public function setCar(Car $car): self
    {
        $this->car = $car;
        return $this;
    }
}