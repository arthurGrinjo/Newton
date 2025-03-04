<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Factory\CarFactory;
use App\Factory\CustomerFactory;
use App\Factory\ModelFactory;
use App\Repository\CustomerRepository;

readonly class CustomerCarFixtures
{
    public function __construct(
        private CustomerRepository $customerRepository,
    ){}

    public function loadCustomerCarFixtures(int $number = 20): void
    {
        CustomerFactory::createMany($number);

        $customers = $this->customerRepository->findAll();

        foreach ($customers as $customer) {
            $this->loadCar($customer);

            // add another car for 12,5% of the customers
            if (rand(1, 8) === 1) {
                $this->loadCar($customer);
            }
        }
    }

    private function loadCar(Customer $customer): void
    {
        CarFactory::createOne([
            'customer' => $customer,
            'model' => ModelFactory::random()
        ]);
    }
}
