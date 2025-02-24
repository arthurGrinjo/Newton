<?php

namespace App\DataFixtures;

use App\Factory\MaintenanceJobFactory;
use App\Factory\SparePartFactory;
use App\Repository\BrandRepository;
use Doctrine\Persistence\ObjectManager;
use Random\RandomException;

readonly class MaintenanceJobFixtures
{
    private const MAINTENANCE_JOBS = [
        ['task' => 'Banden wisselen', 'duration' => '4', 'sparepart' => [
                'name' => 'Banden',
                'price' => 80000,
            ]
        ],
        ['task' => 'Olie verversen', 'duration' => '2', 'sparepart' => [
                'name' => 'Olie',
                'price' => 10000,
            ]
        ],
        ['task' => 'Apk', 'duration' => '14'],
        ['task' => 'Storingsdiagnose', 'duration' => '3'],
        ['task' => 'Uitlijnen', 'duration' => '2'],
        ['task' => 'Ruiten service', 'duration' => '2', 'sparepart' => [
                'name' => 'Nieuwe voorruit',
                'price' => 20000,
            ]
        ],
        ['task' => 'Grote beurt', 'duration' => '20'],
        ['task' => 'Kleine beurt', 'duration' => '10'],
        ['task' => 'Distributieriem vervangen', 'duration' => '32', 'sparepart' => [
                'name' => 'Distributie-riem',
                'price' => 60000,
            ]
        ],
    ];

    public function __construct(
        private BrandRepository $brandRepository,
    ) {}

    public function loadMaintenanceJobFixtures(ObjectManager $manager): void
    {
        $brands = $this->brandRepository->findAll();

        foreach (self::MAINTENANCE_JOBS as $maintenanceJob) {
            $spareParts = [];

            if (array_key_exists('sparepart', $maintenanceJob)) {
                foreach ($brands as $brand) {
                    $sparePart = SparePartFactory::createOne([
                        'name' => $maintenanceJob['sparepart']['name'],
                        'price' => $this->generatePrice($maintenanceJob['sparepart']['price'])
                    ]);

                    $spareParts[] = $sparePart;
                    $sparePart->addBrand($brand);
                }
            }


            $job = MaintenanceJobFactory::createOne([
                'task' => $maintenanceJob['task'],
                'duration' => $maintenanceJob['duration'],
                'spareparts' => $spareParts
            ]);
        }
    }

    /**
     * Generate new price based on input
     * +/- 20%, rounded to tens
     */
    private function generatePrice(
        int $price,
    ): int {
        try {
            $addition = (int) round(
                (random_int(0, 40) - 20) / 100 * $price,
                -3
            );

            return $price + $addition;
        } catch (RandomException) {
            return $price;
        }
    }
}
