<?php

namespace App\Messages;

class AirportFrequencyUpdateMessage
{
    public function __construct(private array $frequency)
    {
    }

    public function getFrequency(): array
    {
        return $this->frequency;
    }
}
