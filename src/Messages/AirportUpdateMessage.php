<?php

namespace App\Messages;

class AirportUpdateMessage
{
    public function __construct(private array $airport)
    {
    }

    public function getAirport(): array
    {
        return $this->airport;
    }
}
