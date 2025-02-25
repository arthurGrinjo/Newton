<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\MaintenanceJob;
use App\Repository\CarRepository;
use App\Repository\MaintenanceJobRepository;
use App\Service\ScheduledMaintenanceJobService;

readonly class ScheduledMaintenanceJobFixtures
{
    public function __construct(
        private CarRepository $carRepository,
        private MaintenanceJobRepository $maintenanceJobRepository,
        private ScheduledMaintenanceJobService $scheduledMaintenanceJobService,
    ){}

    public function loadScheduledMaintenanceJobFixtures(int $number = 20): void
    {

        for ($i = 0; $i < (($number>100) ? 100 : $number); ++$i) {
            $car = $this->carRepository->getRandomCar();
            $maintenanceJob = $this->maintenanceJobRepository->getRandomJob();

            if ($car instanceof Car && $maintenanceJob instanceof MaintenanceJob) {
                $this->scheduledMaintenanceJobService->createScheduledMaintenanceJob(
                    car: $car,
                    maintenanceJob: $maintenanceJob,
                );
            }
        }
    }
}
