<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
	name: 'intel:ingest',
	description: 'Ingest data from a source',
	hidden: false,
)]
class IngestorCommand extends Command {
	private $ingestorId;

	public function __construct( string $name = null, $ingestorId = null ) {
		parent::__construct( $name );
		$this->ingestorId = $ingestorId;

	}

	protected function execute( InputInterface $input, OutputInterface $output ): int {
		if ( ! $this->ingestorId ) {
			return Command::INVALID;
		}

		return Command::SUCCESS;
	}
}