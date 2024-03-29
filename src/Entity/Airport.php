<?php

namespace App\Entity;

use App\Repository\AirportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AirportRepository::class)]
class Airport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ident = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 5)]
    private ?string $latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 5)]
    private ?string $longitude = null;

    #[ORM\Column(nullable: true)]
    private ?int $elevation_ft = null;

    #[ORM\Column]
    private ?bool $scheduled_service = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icao = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $iata = null;

    #[ORM\Column(nullable: true)]
    private ?int $external_id = null;

    #[ORM\OneToMany(mappedBy: 'airport', targetEntity: AirportFrequency::class, orphanRemoval: true)]
    private Collection $airportFrequencies;

    #[ORM\OneToMany(mappedBy: 'airport', targetEntity: AirportRunway::class)]
    private Collection $airportRunways;

    public function __construct()
    {
        $this->airportFrequencies = new ArrayCollection();
        $this->airportRunways = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdent(): ?string
    {
        return $this->ident;
    }

    public function setIdent(?string $ident): self
    {
        $this->ident = $ident;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getElevationFt(): ?int
    {
        return $this->elevation_ft;
    }

    public function setElevationFt(?int $elevation_ft): self
    {
        $this->elevation_ft = $elevation_ft;

        return $this;
    }

    public function isScheduledService(): ?bool
    {
        return $this->scheduled_service;
    }

    public function setScheduledService(bool $scheduled_service): self
    {
        $this->scheduled_service = $scheduled_service;

        return $this;
    }

    public function getIcao(): ?string
    {
        return $this->icao;
    }

    public function setIcao(?string $icao): self
    {
        $this->icao = $icao;

        return $this;
    }

    public function getIata(): ?string
    {
        return $this->iata;
    }

    public function setIata(?string $iata): self
    {
        $this->iata = $iata;

        return $this;
    }

    public function getExternalId(): ?int
    {
        return $this->external_id;
    }

    public function setExternalId(?int $external_id): self
    {
        $this->external_id = $external_id;

        return $this;
    }

    /**
     * @return Collection<int, AirportFrequency>
     */
    public function getAirportFrequencies(): Collection
    {
        return $this->airportFrequencies;
    }

    public function addAirportFrequency(AirportFrequency $airportFrequency): self
    {
        if (!$this->airportFrequencies->contains($airportFrequency)) {
            $this->airportFrequencies->add($airportFrequency);
            $airportFrequency->setAirport($this);
        }

        return $this;
    }

    public function removeAirportFrequency(AirportFrequency $airportFrequency): self
    {
        if ($this->airportFrequencies->removeElement($airportFrequency)) {
            // set the owning side to null (unless already changed)
            if ($airportFrequency->getAirport() === $this) {
                $airportFrequency->setAirport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AirportRunway>
     */
    public function getAirportRunways(): Collection
    {
        return $this->airportRunways;
    }

    public function addAirportRunway(AirportRunway $airportRunway): self
    {
        if (!$this->airportRunways->contains($airportRunway)) {
            $this->airportRunways->add($airportRunway);
            $airportRunway->setAirport($this);
        }

        return $this;
    }

    public function removeAirportRunway(AirportRunway $airportRunway): self
    {
        if ($this->airportRunways->removeElement($airportRunway)) {
            // set the owning side to null (unless already changed)
            if ($airportRunway->getAirport() === $this) {
                $airportRunway->setAirport(null);
            }
        }

        return $this;
    }

    public function userFriendlyType(): string
    {
        switch ($this->type) {
            case 'large_airport':
                return 'Large Airport';
            case 'medium_airport':
                return 'Medium Airport';
            case 'small_airport':
                return 'Small Airport';
            case 'closed':
                return 'Closed';
            case 'heliport':
                return 'Heliport';
            case 'balloonport':
                return 'Balloonport';
            case 'seaplane_base':
                return 'Seaplane Base';
            default:
                return 'Unknown';
        }
    }
}
