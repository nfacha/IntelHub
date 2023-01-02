<?php

namespace App\Command\data;

use App\Messages\AirportFrequencyUpdateMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'data:airport:frequency',
    description: 'Update Airport data',
    hidden: false,
)]
class DataAirportFrequencyCommand extends Command
{
    private $messageBus;

    public function __construct(MessageBusInterface $bus)
    {
        parent::__construct('Intel Ingest');
        $this->messageBus = $bus;


    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Updating Airport Frequency data');
        $url = 'https://davidmegginson.github.io/ourairports-data/airport-frequencies.csv';
        $content = file_get_contents($url);
        $csv = array_map('str_getcsv', explode("\n", $content));
        array_shift($csv);
        foreach ($csv as $row) {
            $msg = new AirportFrequencyUpdateMessage($row);
            $this->messageBus->dispatch($msg);
        }
        return Command::SUCCESS;
    }
}
