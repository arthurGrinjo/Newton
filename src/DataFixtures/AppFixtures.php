<?php

namespace App\DataFixtures;

use App\Factory\EngineerFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly CustomerCarFixtures $customerCarFixtures,
        private readonly ModelFixtures       $modelFixtures,
    ){}

    public function load(ObjectManager $manager): void
    {
        $this->modelFixtures->loadModelFixtures();
        $this->customerCarFixtures->loadCustomerCarFixtures(number: 50);
        EngineerFactory::createMany(5);
        
        $manager->flush();
    }
}
