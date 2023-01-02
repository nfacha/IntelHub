<?php

namespace App\Entity;

use App\Repository\AirportRunwayRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AirportRunwayRepository::class)]
class AirportRunway
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'airportRunways')]
    private ?Airport $airport = null;

    #[ORM\Column(nullable: true)]
    private ?int $lenght_ft = null;

    #[ORM\Column(nullable: true)]
    private ?int $width_ft = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surface = null;

    #[ORM\Column]
    private ?bool $lighted = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $le_ident = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $he_ident = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAirport(): ?Airport
    {
        return $this->airport;
    }

    public function setAirport(?Airport $airport): self
    {
        $this->airport = $airport;

        return $this;
    }

    public function getLenghtFt(): ?int
    {
        return $this->lenght_ft;
    }

    public function setLenghtFt(?int $lenght_ft): self
    {
        $this->lenght_ft = $lenght_ft;

        return $this;
    }

    public function getWidthFt(): ?int
    {
        return $this->width_ft;
    }

    public function setWidthFt(?int $width_ft): self
    {
        $this->width_ft = $width_ft;

        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(?string $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function isLighted(): ?bool
    {
        return $this->lighted;
    }

    public function setLighted(bool $lighted): self
    {
        $this->lighted = $lighted;

        return $this;
    }

    public function getLeIdent(): ?string
    {
        return $this->le_ident;
    }

    public function setLeIdent(?string $le_ident): self
    {
        $this->le_ident = $le_ident;

        return $this;
    }

    public function getHeIdent(): ?string
    {
        return $this->he_ident;
    }

    public function setHeIdent(?string $he_ident): self
    {
        $this->he_ident = $he_ident;

        return $this;
    }
}
