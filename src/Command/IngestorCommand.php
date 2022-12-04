<?php

namespace App\Command;

use App\Enum\SourceFeedType;
use App\Enum\SourceType;
use App\Repository\IngestorRepository;
use React\Socket\SocketServer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
	name: 'intel:ingest',
	description: 'Ingest data from a source',
	hidden: false,
)]
class IngestorCommand extends Command {
	private $ingestorId;
	private $ingestorRepository;

	public function __construct( IngestorRepository $ingestorRepository ) {
		parent::__construct( 'Intel Ingest' );
		$this->ingestorRepository = $ingestorRepository;

	}

	protected function configure(): void {
		$this
			->addArgument( 'ingestorId', InputArgument::REQUIRED, 'The ID of the ingestor.' );
	}

	protected function execute( InputInterface $input, OutputInterface $output ): int {
		$this->ingestorId = $input->getArgument( 'ingestorId' );
		if ( ! $this->ingestorId ) {
			$output->writeln( 'No ingestor ID provided' );

			return Command::INVALID;
		}
		$ingestor = $this->ingestorRepository->find( $this->ingestorId );
		if ( ! $ingestor ) {
			$output->writeln( 'Ingestor not found' );

			return Command::INVALID;
		}
		if ( $ingestor->getActive() === false ) {
			$output->writeln( 'Ingestor is not active' );

			return Command::INVALID;
		}
		$output->writeln( 'Ingestor found: ' . $ingestor->getName() );
		switch ( $ingestor->getSourceType() ) {
			case SourceType::PULL_SOURCE:
				$output->writeln( 'Pull Source' );
				break;
			case SourceType::PUSH_SOURCE:
				$output->writeln( 'Push Source' );
				//Data is feed INTO intel hub, so we need to spin up our socket
				$this->initSocket( (int) $ingestor->getPushPort(), SourceFeedType::ADSB_BASESTATION, $output );
				break;
		}


		return Command::SUCCESS;
	}

	private function initSocket( int $port, int $protocol, OutputInterface $output ) {
		$output->writeln( 'Starting socket on port ' . $port );
		$socket = new SocketServer( '0.0.0.0:' . $port );

		$socket->on( 'connection', function ( $conn ) use ( $protocol, $output ) {
			$conn->on( 'data', function ( $data ) use ( $output, $conn, $protocol ) {
//				$protocol->processData($data);
				$output->writeln( 'Data received: ' . $data );
			} );
		} );
	}
}