<?php

namespace App\MessageHandlers;

use App\Messages\ADSBMessage;
use App\Protocol\ADSB\BaseStation\BaseStationMessage;
use App\Repository\AircraftPositionRepository;
use App\Repository\AircraftRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ADSBMessageHandler implements MessageHandlerInterface
{

    private $aircraftRepository;
    private $aircraftPositionRepository;

    public function __construct(AircraftRepository $aircraftRepository, AircraftPositionRepository $aircraftPositionRepository)
    {
        $this->aircraftRepository = $aircraftRepository;
        $this->aircraftPositionRepository = $aircraftPositionRepository;
    }

    public function __invoke(ADSBMessage $message)
    {
        $msg = new BaseStationMessage($message->getContent(), $this->aircraftRepository, $this->aircraftPositionRepository);
        print_r($msg->getDescription());
    }
}
