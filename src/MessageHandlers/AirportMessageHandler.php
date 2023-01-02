<?php

namespace App\MessageHandlers;

use App\Messages\AirportUpdateMessage;
use App\Repository\AirportRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AirportMessageHandler implements MessageHandlerInterface
{

    private $airportRepository;

    public function __construct(AirportRepository $airportRepository)
    {
        $this->airportRepository = $airportRepository;

    }

    public function __invoke(AirportUpdateMessage $message)
    {
        $this->airportRepository->updateAirport($message->getAirport());

    }


}
