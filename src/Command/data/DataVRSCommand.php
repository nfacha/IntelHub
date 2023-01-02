<?php

namespace App\Command\data;

use App\Messages\VRSDataUpdateMessage;
use App\Repository\AircraftRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'data:vrs',
    description: 'Update VRS data',
    hidden: false,
)]
class DataVRSCommand extends Command
{
    private $aircraftRepository;
    private $messageBus;

    public function __construct(AircraftRepository $aircraftRepository, MessageBusInterface $bus)
    {
        parent::__construct('VRS Update');
        $this->aircraftRepository = $aircraftRepository;
        $this->messageBus = $bus;

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Updating VRS data');
        $aircraft = $this->aircraftRepository->createQueryBuilder('a')
            ->select()
            ->where('a.last_data_update_at is null')
            ->getQuery()
//            ->setMaxResults(100)
            ->getResult();
        $icaos = [];
        foreach ($aircraft as $a) {
            $icaos[] = $a->getIcao();
        }
        $data = new VRSDataUpdateMessage($icaos);
        $this->messageBus->dispatch($data);
        return Command::SUCCESS;
    }
}
