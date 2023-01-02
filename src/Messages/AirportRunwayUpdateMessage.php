<?php

namespace App\Messages;

class AirportRunwayUpdateMessage
{
    public function __construct(private array $runway)
    {
    }

    public function getRunway(): array
    {
        return $this->runway;
    }
}
