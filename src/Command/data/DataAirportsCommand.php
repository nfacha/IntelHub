<?php

namespace App\Command\data;

use App\Repository\AirportRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'data:airport',
    description: 'Update Airport data',
    hidden: false,
)]
class DataAirportsCommand extends Command
{
    private $airportRepository;

    public function __construct(AirportRepository $airportRepository)
    {
        parent::__construct('Intel Ingest');
        $this->airportRepository = $airportRepository;

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Updating Airport data');
        $url = 'https://davidmegginson.github.io/ourairports-data/airports.csv';
        $content = file_get_contents($url);
        $csv = array_map('str_getcsv', explode("\n", $content));
        array_shift($csv);
        foreach ($csv as $row) {
            $this->airportRepository->updateAirport($row);
        }
        return Command::SUCCESS;
    }
}
