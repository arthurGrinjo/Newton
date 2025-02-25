<?php

declare(strict_types=1);

namespace App\Command;

use App\DataFixtures\ScheduledMaintenanceJobFixtures;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'newton:jobs:load',
    description: 'Generate fixtures for scheduled jobs.',
)]
class LoadScheduledJobsCommand extends Command
{
    public function __construct(
        private readonly ScheduledMaintenanceJobFixtures $scheduledMaintenanceJobFixtures,
        string $name = 'newton:jobs:load',
    ){
        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');
        /** @phpstan-ignore method.notFound */
        $number = $helper->ask($input, $output, new Question("Number of jobs to generate (max 100): "));

        if ($number !== null && is_numeric($number) === false) {
            $io->error('Number must be an integer.');
            return Command::INVALID;
        }

        $this->scheduledMaintenanceJobFixtures->loadScheduledMaintenanceJobFixtures((int) $number);

        return Command::SUCCESS;
    }
}