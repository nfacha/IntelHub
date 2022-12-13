<?php

namespace App\Messages;

class MictronicsFileMessage
{
    public function __construct(private string $name, private array $jsonData)
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getJsonData(): array
    {
        return $this->jsonData;
    }

}
