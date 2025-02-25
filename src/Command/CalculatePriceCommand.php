<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Car;
use App\Entity\Customer;
use App\Entity\ScheduledMaintenanceJob;
use App\Repository\CarRepository;
use App\Repository\CustomerRepository;
use App\Repository\ScheduledMaintenanceJobRepository;
use App\Service\ScheduledMaintenanceJobService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'newton:jobs:calculate-price',
    description: 'Generate fixtures for scheduled jobs.',
)]
class CalculatePriceCommand extends Command
{
    public function __construct(
        private readonly CarRepository $carRepository,
        private readonly CustomerRepository $customerRepository,
        private readonly ScheduledMaintenanceJobRepository $scheduledMaintenanceJobRepository,
        private readonly ScheduledMaintenanceJobService $scheduledMaintenanceJobService,
        string $name = 'newton:jobs:calculate-price',
    ){
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');
        /**
         * @var string $search
         * @phpstan-ignore method.notFound
         */
        $search = $helper->ask($input, $output, new Question("Enter part of the name of a customer: "));

        $customer = $this->getCustomer($search, $input, $output, $helper);

        if (!$customer instanceof Customer) {
            $io->error(sprintf('No customers found for: %s', $search));
            return Command::FAILURE;
        }

        $car = $this->getCar($customer, $input, $output, $helper);

        if (!$car instanceof Car) {
            $io->error(sprintf('No car found for customer: %s', $customer->getName()));
            return Command::FAILURE;
        }

        $io->info(
            sprintf(
                "Car found for customer: %s, %s - %s",
                $customer->getName(),
                $car->getModel()->getBrand()->getName(),
                $car->getModel()->getName(),
            )
        );

        $service = $this->scheduledMaintenanceJobService;
        $listOfPrices = [];

        array_map(function(ScheduledMaintenanceJob $job) use (&$service, &$listOfPrices): void {
            $listOfPrices[] = $service->getInvoiceForScheduledMaintenanceJob($job);
        },
            $this->scheduledMaintenanceJobRepository->findBy(['car' => $car])
        );

        $table = new Table($output);
        $table
            ->setHeaders(['Task', 'Date', 'Working hours', 'SpareParts', 'Price (€)', '21% VAT (€)', 'Total price (€)'])
            ->setRows($listOfPrices)
            ->render()
        ;

        return Command::SUCCESS;
    }

    private function getCustomer(
        string $search,
        InputInterface $input,
        OutputInterface $output,
        HelperInterface $helper,
    ): ?Customer {
        $customers = $this->customerRepository->findCustomerByName($search);
        $customer = null;

        if (count($customers) === 1) {
            $customer = $customers[0];
        }

        if (count($customers) > 1) {
            /** @phpstan-ignore method.notFound */
            $selected = $helper->ask(
                $input,
                $output,
                new ChoiceQuestion(
                    'Please select customer: ',
                    array_map(static fn(Customer $customer): string => $customer->getName(), $customers),
                ),
            );

            foreach ($customers as $c) {
                if ($c->getName() === $selected) {
                    $customer = $c;
                    break;
                }
            }
        }
        return $customer;
    }

    private function getCar(
        Customer $customer,
        InputInterface $input,
        OutputInterface $output,
        HelperInterface $helper,
    ): ?Car {
        $cars = $this->carRepository->findBy(['customer' => $customer]);
        $car = null;

        if (count($cars) === 1) {
            $car = $cars[0];
        }

        if (count($cars) > 1) {
            /** @phpstan-ignore method.notFound */
            $selected = $helper->ask(
                $input,
                $output,
                new ChoiceQuestion(
                    'Please select car: ',
                    array_map(static fn(Car $car): string => $car->getModel()->getName(), $cars),
                ),
            );

            foreach ($cars as $c) {
                if ($c->getModel()->getName() === $selected) {
                    $car = $c;
                    break;
                }
            }
        }
        return $car;
    }
}