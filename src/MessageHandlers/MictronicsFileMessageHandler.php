<?php

namespace App\MessageHandlers;

use App\Entity\Aircraft;
use App\Messages\MictronicsFileMessage;
use App\Repository\AircraftRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MictronicsFileMessageHandler implements MessageHandlerInterface
{

    private $aircraftRepository;


    public function __construct(AircraftRepository $aircraftRepository)
    {
        $this->aircraftRepository = $aircraftRepository;

    }

    public function __invoke(MictronicsFileMessage $message)
    {
        $name = $message->getName();
        $json_data = $message->getJsonData();
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
}
