<?php

namespace App\MessageHandlers;

use App\libs\VRSData;
use App\Messages\VRSDataUpdateMessage;
use App\Repository\AircraftRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class VRSDataUpdateMessageHandler implements MessageHandlerInterface
{

    private $aircraftRepository;

    public function __construct(AircraftRepository $aircraftRepository)
    {
        $this->aircraftRepository = $aircraftRepository;
    }

    public function __invoke(VRSDataUpdateMessage $message)
    {
        $icaos = $message->getIcaos();
        //if icaos has more than 400 elements split in array of 400 each
        if (count($icaos) > 400) {
            $sections = array_chunk($icaos, 400);
            foreach ($sections as $section) {
                $this->updateAircraftData($section);
            }
        } else {
            $this->updateAircraftData($icaos);
        }

        $vrsData = new VRSData();
    }
}
