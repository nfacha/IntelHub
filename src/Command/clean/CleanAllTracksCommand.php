<?php

namespace App\Command\clean;

use App\Repository\AircraftPositionRepository;
use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'clean:all-tracks',
    description: 'Clean old tracks',
    hidden: false,
)]
class CleanAllTracksCommand extends Command
{
    private $aircraftPositionRepository;
    private $messageBus;

    public function __construct(AircraftPositionRepository $aircraftpositionRepository, MessageBusInterface $bus)
    {
        parent::__construct('Clean old tracks');
        $this->aircraftPositionRepository = $aircraftpositionRepository;
        $this->messageBus = $bus;

    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $days = 7;

        $output->writeln('Cleaning tracks older than ' . $days . ' days');
        $total = $this->aircraftPositionRepository->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->execute();
        $output->writeln('Deleted ' . $total . ' tracks');
        return Command::SUCCESS;
    }
}
