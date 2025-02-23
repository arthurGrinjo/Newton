<?php

namespace App\DataFixtures;

use App\Factory\BrandFactory;
use App\Factory\ModelFactory;
use Doctrine\Persistence\ObjectManager;

readonly class ModelFixtures
{
    private const BRANDS = [
        ['name' => 'Citroën', 'models' =>
            ['C1', 'C2', 'C3', 'C4', 'C5'],
        ],
        ['name' => 'Peugeot', 'models' =>
            ['208', '308', '408', '508'],
        ],
        ['name' => 'Tesla', 'models' =>
            ['Model X', 'Model Y'],
        ],
        ['name' => 'Polestar', 'models' =>
            ['Polestar 2', 'Polestar 3', 'Polestar 4']
        ],
    ];

    public function loadModelFixtures(ObjectManager $manager): void
    {
        foreach (self::BRANDS as $brand) {
            $newBrand = BrandFactory::createOne([
                'name' => $brand['name']
            ]);

            foreach ($brand['models'] as $model) {
                ModelFactory::createOne([
                    'name' => $model,
                    'brand' => $newBrand,
                ]);
            }
        }
    }
}
