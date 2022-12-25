<?php

namespace App\Messages;

class VRSDataUpdateMessage
{
    public function __construct(private string $icaos)
    {
    }

    public function getIcaos(): string
    {
        return $this->icaos;
    }
}
