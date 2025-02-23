<?php

namespace App\DataFixtures;

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
        $this->modelFixtures->loadModelFixtures($manager);
        $this->customerCarFixtures->loadCustomerCarFixtures($manager);
        $manager->flush();
    }
}
