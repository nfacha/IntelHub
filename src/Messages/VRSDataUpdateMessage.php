<?php

namespace App\Messages;

class VRSDataUpdateMessage
{
    public function __construct(private array $icaos)
    {
    }

    public function getIcaos(): array
    {
        return $this->icaos;
    }
}
