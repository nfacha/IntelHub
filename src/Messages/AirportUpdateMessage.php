<?php

namespace App\Messages;

class AirportUpdateMessage
{
    public function __construct(private array $frequency)
    {
    }

    public function getfrequency(): array
    {
        return $this->frequency;
    }
}
