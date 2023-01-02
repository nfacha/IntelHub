<?php

namespace App\Entity;

use App\Repository\AircraftPositionRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AircraftPositionRepository::class)]
class AircraftPosition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?DateTimeImmutable $position_at = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 5, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 5, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $track = null;

    #[ORM\Column(nullable: true)]
    private ?int $vertical_rate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $squawk = null;

    #[ORM\Column(nullable: true)]
    private ?bool $on_ground = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $callsign = null;

    #[ORM\Column(length: 255)]
    private ?string $icao = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPositionAt(): ?DateTimeImmutable
    {
        return $this->position_at;
    }

    public function setPositionAt(DateTimeImmutable $position_at): self
    {
        $this->position_at = $position_at;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getTrack(): ?string
    {
        return $this->track;
    }

    public function setTrack(?string $track): self
    {
        $this->track = $track;

        return $this;
    }

    public function getVerticalRate(): ?int
    {
        return $this->vertical_rate;
    }

    public function setVerticalRate(?int $vertical_rate): self
    {
        $this->vertical_rate = $vertical_rate;

        return $this;
    }

    public function getSquawk(): ?string
    {
        return $this->squawk;
    }

    public function setSquawk(?string $squawk): self
    {
        $this->squawk = $squawk;

        return $this;
    }

    public function isOnGround(): ?bool
    {
        return $this->on_ground;
    }

    public function setOnGround(?bool $on_ground): self
    {
        $this->on_ground = $on_ground;

        return $this;
    }

    public function getCallsign(): ?string
    {
        return $this->callsign;
    }

    public function setCallsign(?string $callsign): self
    {
        $this->callsign = $callsign;

        return $this;
    }

    public function getIcao(): ?string
    {
        return $this->icao;
    }

    public function setIcao(string $icao): self
    {
        $this->icao = $icao;

        return $this;
    }
}
