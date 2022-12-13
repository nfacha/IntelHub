<?php

namespace App\Command;

use App\Enum\MessageProtocol;
use App\Enum\SourceType;
use App\Messages\ADSBMessage;
use App\Repository\IngestorRepository;
use React\Socket\SocketServer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'intel:ingest',
    description: 'Ingest data from a source',
    hidden: false,
)]
class IngestorCommand extends Command
{
    private $ingestorRepository;
    private $messageBus;

    public function __construct(IngestorRepository $ingestorRepository, MessageBusInterface $bus)
    {
        parent::__construct('Intel Ingest');
        $this->ingestorRepository = $ingestorRepository;
        $this->messageBus = $bus;

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ingestors = $this->ingestorRepository->createQueryBuilder('i')
            ->where('i.active = 1')
            ->andWhere('i.source_type = :source_type')
            ->setParameter('source_type', SourceType::PUSH_SOURCE)
            ->getQuery()->getResult();

        echo "Found " . count($ingestors) . " ingestors\n";
        foreach ($ingestors as $ingestor) {
            $output->writeln('Ingestor found: ' . $ingestor->getName());
            switch ($ingestor->getSourceType()) {
                case SourceType::PULL_SOURCE:
                    $output->writeln('Pull Source');
                    break;
                case SourceType::PUSH_SOURCE:
                    $output->writeln('Push Source');
                    //Data is feed INTO intel hub, so we need to spin up our socket
                    $this->initSocket((int)$ingestor->getPushPort(), MessageProtocol::ADSB_BASESTATION, $output, $this->messageBus);
                    break;
            }
        }

        return Command::SUCCESS;
    }

    private function initSocket(int $port, int $protocol, OutputInterface $output, MessageBusInterface $bus)
    {
        $output->writeln('Starting socket on port ' . $port);
        $socket = new SocketServer('0.0.0.0:' . $port);

        $socket->on('connection', function ($conn) use ($bus, $protocol) {
            $conn->on('data', function ($data) use ($bus, $protocol) {
                switch ($protocol) {
                    case MessageProtocol::ADSB_BASESTATION:
                        $msg = new ADSBMessage($data);
                        $bus->dispatch($msg);
                        break;
                }
            });
        });
    }
}
