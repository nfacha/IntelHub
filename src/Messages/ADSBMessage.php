<?php

namespace App\Messages;

class ADSBMessage
{
    public function __construct(private string $content)
    {
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
