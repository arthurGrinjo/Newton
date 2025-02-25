<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Car;
use App\Entity\Engineer;
use App\Entity\MaintenanceJob;
use App\Entity\ScheduledMaintenanceJob;
use App\Entity\TimeSlot;
use App\Repository\EngineerRepository;
use App\Repository\ScheduledMaintenanceJobRepository;
use App\Repository\SparePartRepository;
use DateInterval;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

readonly class ScheduledMaintenanceJobService
{
    const PRICE_PER_HOUR = 10000;
    const VAT = 21;
    const WEEKEND_TARIF = 150;

    public function __construct(
        private EngineerRepository $engineerRepository,
        private EntityManagerInterface $manager,
        private ScheduledMaintenanceJobRepository $scheduledMaintenanceJobRepository,
        private SparePartRepository $sparePartRepository,
    ) {}

    public function createScheduledMaintenanceJob(
        Car $car,
        MaintenanceJob $maintenanceJob,
    ): void {
        /** @var array<int,Engineer> $engineers */
        $engineers = [];
        array_map(function(Engineer $engineer) use (&$engineers): void {
            $engineers[(int) $engineer->getId()] = $engineer;
        },
            $this->engineerRepository->findAll()
        );

        /** @var array<int, array{id: int, date: DateTimeImmutable, start: int, end: int}> $scheduledJobs */
        $scheduledJobs = [];
        array_map(function(array $scheduledJob) use (&$scheduledJobs): void {
                $scheduledJobs[(int) $scheduledJob['id']] = $scheduledJob;
            },
            $this->scheduledMaintenanceJobRepository->getEarliestJobAndEngineer(count($engineers))
        );

        /**
         * - plan for engineer who is the first without a job
         */
        $engineer = $this->getEngineer(scheduledJobs: $scheduledJobs, engineers: $engineers);

        /**
         * - every job takes 15 minutes to start/stop
         */
        if (array_key_exists((int) $engineer->getId(), $scheduledJobs)) {
            $lastJob = $scheduledJobs[$engineer->getId()];

            $start = $lastJob['end'] % 32;
            $end = $start + $maintenanceJob->getDuration() + 1;
            /** @var DateTimeImmutable $date */
            $date = ($lastJob['end'] < 32)
                ? $lastJob['date']
                : $lastJob['date']->add(new DateInterval('P1D'));

            // exclude sundays and mondays
            if (in_array($date->format('N'), [1, 7])) {
                $date = $date->add(new DateInterval('P2D'));
            }

            $timeSlot = new TimeSlot(
                date: $date,
                start: $start,
                end: $end,
            );
        } else {
            $timeSlot = new TimeSlot(
                date: $this->getScheduleFrom(),
                start: 0,
                end: $maintenanceJob->getDuration() + 1,
            );
        }

        $this->manager->persist($timeSlot);

        $scheduledMaintenanceJob = new ScheduledMaintenanceJob(
            engineer: $engineer,
            timeSlot: $timeSlot,
            maintenanceJob: $maintenanceJob,
            car: $car,
        );

        $this->manager->persist($scheduledMaintenanceJob);
        $this->manager->flush();
    }

    /**
     * @return array{task: string, date: string, working_hours: string, spare_part_price: float, price: float, vat: float, total_price: float}
     */
    public function getInvoiceForScheduledMaintenanceJob(
        ScheduledMaintenanceJob $scheduledMaintenanceJob,
    ): array {
            $sparePartPrice = ($scheduledMaintenanceJob->getMaintenanceJob()->getSpareParts()->count() > 0)
                ? $this->sparePartRepository->getSparePartPrice(
                    sparePart: $scheduledMaintenanceJob->getMaintenanceJob()->getSpareParts()->first(),
                    car: $scheduledMaintenanceJob->getCar()
                )
                : 0
            ;

        /** todo: implement weekend tarif of 150% */
        $workingHoursPrice = $scheduledMaintenanceJob->getTimeSlot()->getDuration() * self::PRICE_PER_HOUR / 4;

        $totalPrice = $sparePartPrice + $workingHoursPrice;
        $vat = $totalPrice * self::VAT / 100;

        return [
            'task' => $scheduledMaintenanceJob->getMaintenanceJob()->getTask(),
            'date' => $scheduledMaintenanceJob->getTimeSlot()->getDate()->format('Y-m-d'),
            'working_hours' => sprintf('%sh', $scheduledMaintenanceJob->getTimeSlot()->getDuration() / 4),
            'spare_part_price' => $sparePartPrice / 100,
            'price' => $totalPrice / 100,
            'vat' => $vat / 100,
            'total_price' => ($totalPrice + $vat) / 100,
        ];
    }

    /**
     * @param array<int, array{id: int, date: DateTimeImmutable, start: int, end: int}> $scheduledJobs ,
     * @param array<int, Engineer> $engineers
     */
    private function getEngineer(
        array $scheduledJobs,
        array $engineers,
    ): Engineer {
        // Check if there are engineers without jobs
        foreach ($engineers as $id => $engineer) {
            if (!array_key_exists($id, $scheduledJobs)) {
                return $engineer;
            }
        }

        $latest = array_pop($scheduledJobs);
        return $engineers[$latest['id']];
    }

    private function getScheduleFrom(): DateTimeImmutable
    {
        $now = new DateTimeImmutable();

        return ($now->format('G') < 8)
            ? $now->setTime(hour: 8, minute: 0)
            : $now->setTime(hour: 8, minute: 0)->add(new DateInterval('PT24H'));
    }
}