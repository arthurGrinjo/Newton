<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: CarRepository::class)]
class Car implements EntityInterface
{
    use IdentifiableEntity;

    #[ManyToOne(targetEntity: Customer::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private Customer $customer;

    #[ManyToOne(targetEntity: Model::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private Model $model;

    /**
     * @var Collection<int, ScheduledMaintenanceJob>
     */
    #[OneToMany(targetEntity: ScheduledMaintenanceJob::class, mappedBy: 'car')]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private Collection $scheduledMaintenanceJobs;

    public function __construct(
        Customer $customer,
        Model $model,
    ) {
        $this->uuid = Uuid::v6();
        $this->scheduledMaintenanceJobs = new ArrayCollection();
        $this
            ->setCustomer($customer)
            ->setModel($model)
        ;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;
        return $this;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;
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
        if ($this->scheduledMaintenanceJobs->contains($scheduledMaintenanceJob) === false) {
            $this->scheduledMaintenanceJobs->add($scheduledMaintenanceJob);
        }
        return $this;
    }

    public function removeScheduledMaintenanceJob(ScheduledMaintenanceJob $scheduledMaintenanceJob): self
    {
        $this->scheduledMaintenanceJobs->removeElement($scheduledMaintenanceJob);
        return $this;
    }
}