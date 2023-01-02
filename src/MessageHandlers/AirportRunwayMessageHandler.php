<?php

namespace App\MessageHandlers;

use App\Messages\AirportRunwayUpdateMessage;
use App\Repository\AirportRunwayRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AirportRunwayMessageHandler implements MessageHandlerInterface
{

    private $airportRunwayRepository;

    public function __construct(AirportRunwayRepository $airportRunwayRepository)
    {
        $this->airportRunwayRepository = $airportRunwayRepository;

    }

    public function __invoke(AirportRunwayUpdateMessage $message)
    {
        $this->airportRunwayRepository->updateRunway($message->getRunway());

    }


}
