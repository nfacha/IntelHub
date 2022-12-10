<?php

namespace App\Entity;

use App\Repository\AircraftRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AircraftRepository::class)]
class Aircraft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $icao = null;

    #[ORM\Column]
    private ?bool $is_military = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $registration = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $manufacturer = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $model = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $model_icao = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $operator = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $operator_icao = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $serial = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $year_build = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function isIsMilitary(): ?bool
    {
        return $this->is_military;
    }

    public function setIsMilitary(bool $is_military): self
    {
        $this->is_military = $is_military;

        return $this;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(?string $registration): self
    {
        $this->registration = $registration;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getModelIcao(): ?string
    {
        return $this->model_icao;
    }

    public function setModelIcao(?string $model_icao): self
    {
        $this->model_icao = $model_icao;

        return $this;
    }

    public function getOperator(): ?string
    {
        return $this->operator;
    }

    public function setOperator(?string $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    public function getOperatorIcao(): ?string
    {
        return $this->operator_icao;
    }

    public function setOperatorIcao(?string $operator_icao): self
    {
        $this->operator_icao = $operator_icao;

        return $this;
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function setSerial(?string $serial): self
    {
        $this->serial = $serial;

        return $this;
    }

    public function getYearBuild(): ?string
    {
        return $this->year_build;
    }

    public function setYearBuild(?string $year_build): self
    {
        $this->year_build = $year_build;

        return $this;
    }
}
