<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Uid\Uuid;

#[Entity(repositoryClass: CarRepository::class)]
class Car implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::STRING, length: 100, nullable: false)]
    private string $name;

    #[ManyToOne(targetEntity: Customer::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private Customer $customer;

    #[ManyToOne(targetEntity: Model::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private Model $model;

    /**
     * @var Collection<int, ScheduledMaintenanceJob>
     */
    #[ManyToMany(targetEntity: ScheduledMaintenanceJob::class)]
    #[JoinColumn(referencedColumnName: 'id', nullable: false)]
    private Collection $scheduledMaintenanceJobs;

    public function __construct(
        string $name,
        Customer $customer,
        Model $model,
    ) {
        $this->uuid = Uuid::v6();
        $this->scheduledMaintenanceJobs = new ArrayCollection();
        $this
            ->setName($name)
            ->setCustomer($customer)
            ->setModel($model)
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
}