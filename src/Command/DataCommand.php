<?php

namespace App\Command;

use App\Entity\Aircraft;
use App\Repository\AircraftRepository;
use Exception;
use JsonException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZipArchive;

#[AsCommand(
    name: 'data:mictronics',
    description: 'Update Mectronics data',
    hidden: false,
)]
class DataCommand extends Command
{
    private $aircraftRepository;

    public function __construct(AircraftRepository $aircraftRepository)
    {
        parent::__construct('Intel Ingest');
        $this->aircraftRepository = $aircraftRepository;

    }

    /**
     * @throws JsonException
     */
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
            echo "Parsing file: " . $name . PHP_EOL;
            $icaos = array_keys($json_data);
            //loop icaos
            foreach ($icaos as $icao) {
                $filePrefix = str_replace('.json', '', $name);
//                echo "File prefix is $filePrefix\n";
                $fullIcao = strtoupper($filePrefix . $icao);
                echo "Parsing ICAO: " . $fullIcao . PHP_EOL;
                if (!array_key_exists('r', $json_data[$icao])) {
                    echo "No registration found for $icao, possibly invalid hex\n";
                    continue;
                }
                $aircraft = $this->aircraftRepository->findOneBy(['icao' => $icao]);
                try {
                    if (!$aircraft) {
                        $aircraft = new Aircraft();
                        $aircraft->setIcao($icao);
                        $aircraft->setRegistration($json_data[$icao]['r']);
                        $aircraft->setModelIcao($json_data[$icao]['t']);
                        $aircraft->setIsMilitary($json_data[$icao]['f'] === "10");
                        $aircraft->setModel($json_data[$icao]['desc']);
                        echo "Adding new Aircraft: " . $icao . PHP_EOL;
                    }
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage() . PHP_EOL;
                    var_dump($json_data[$icao]);
                    die();
                }
                $this->aircraftRepository->save($aircraft, true);
            }
        }

        return Command::SUCCESS;
    }
}
