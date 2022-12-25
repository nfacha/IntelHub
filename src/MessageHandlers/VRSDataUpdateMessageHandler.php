<?php

namespace App\MessageHandlers;

use App\libs\VRSData;
use App\Messages\VRSDataUpdateMessage;
use App\Repository\AircraftRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class VRSDataUpdateMessageHandler implements MessageHandlerInterface
{

    private $aircraftRepository;
    private $vrsData;

    public function __construct(AircraftRepository $aircraftRepository)
    {
        $this->aircraftRepository = $aircraftRepository;
        $this->vrsData = new VRSData();

    }

    public function __invoke(VRSDataUpdateMessage $message)
    {
        $icaos = $message->getIcaos();
        if (count($icaos) > 400) {
            $sections = array_chunk($icaos, 400);
            foreach ($sections as $section) {
                $this->updateAircraftData($section);
            }
        } else {
            $this->updateAircraftData($icaos);
        }

    }

    private function updateAircraftData(array $icaos): void
    {
        $data = $this->vrsData->getAircraftData($icaos);
        foreach ($data as $row) {
            $aircraft = $this->aircraftRepository->findOneBy(['icao' => $row['Icao']]);
            if ($aircraft) {
                $aircraft->updateFromVRSData($row);
                $this->aircraftRepository->save($aircraft, true);
            }
        }
    }
}
