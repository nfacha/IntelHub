<?php

namespace App\MessageHandlers;

use App\Messages\AirportFrequencyUpdateMessage;
use App\Repository\AirportFrequencyRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AirportFrequencyMessageHandler implements MessageHandlerInterface
{

    private $airportFrequecyRepository;

    public function __construct(AirportFrequencyRepository $airportFrequencyRepository)
    {
        $this->airportFrequecyRepository = $airportFrequencyRepository;

    }

    public function __invoke(AirportFrequencyUpdateMessage $message)
    {
        $this->airportFrequecyRepository->updateFrequency($message->getFrequency());

    }


}
