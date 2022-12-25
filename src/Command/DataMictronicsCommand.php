<?php

namespace App\Command;

use App\Messages\MictronicsFileMessage;
use App\Repository\AircraftRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use ZipArchive;

#[AsCommand(
    name: 'data:mictronics',
    description: 'Update Mectronics data',
    hidden: false,
)]
class DataMictronicsCommand extends Command
{
    private $aircraftRepository;
    private $messageBus;

    public function __construct(AircraftRepository $aircraftRepository, MessageBusInterface $bus)
    {
        parent::__construct('Intel Ingest');
        $this->aircraftRepository = $aircraftRepository;
        $this->messageBus = $bus;

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Updating Mectronics data');
        $hash = md5(uniqid(mt_rand(), true));
        $path = sys_get_temp_dir() . '/aircraft_db/' . $hash . '/';
        // Download the file to a temporary folder
        echo $path . "\n";
        $temp_file = @tempnam($path, 'aircraft_db');
        echo "Downloading file to $temp_file\n";
        file_put_contents($temp_file, file_get_contents('https://www.mictronics.de/aircraft-database/aircraft_db.php'));

// Extract the files from the downloaded archive
        $zip = new ZipArchive();
        $res = $zip->open($temp_file);
        if ($res === true) {
            echo "Extracting files to $path\n";
            $zip->extractTo($path . 'data/');
            $zip->close();
        }

// Loop through all of the JSON files in the temporary folder
        foreach (glob($path . 'data/*.json') as $json_file) {
            // Read and parse the JSON file
            $name = basename($json_file);
            $json_data = json_decode(file_get_contents($json_file), true, 512, JSON_THROW_ON_ERROR);
            $data = new MictronicsFileMessage($name, $json_data);
            $this->messageBus->dispatch($data);
            echo "Dispatched $name\n";
        }

        return Command::SUCCESS;
    }
}
