<?php

namespace App\Entity;

use App\Repository\AircraftRepository;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $picture_url = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $last_data_update_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $last_picture_update_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo_author = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $photo_link = null;

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

    public function getPictureUrl(): ?string
    {
        return $this->picture_url;
    }

    public function setPictureUrl(?string $picture_url): self
    {
        $this->picture_url = $picture_url;

        return $this;
    }

    public function getLastDataUpdateAt(): ?\DateTimeImmutable
    {
        return $this->last_data_update_at;
    }

    public function setLastDataUpdateAt(?\DateTimeImmutable $last_data_update_at): self
    {
        $this->last_data_update_at = $last_data_update_at;

        return $this;
    }

    public function getLastPictureUpdateAt(): ?\DateTimeImmutable
    {
        return $this->last_picture_update_at;
    }

    public function setLastPictureUpdateAt(?\DateTimeImmutable $last_picture_update_at): self
    {
        $this->last_picture_update_at = $last_picture_update_at;

        return $this;
    }

    public function getPhotoAuthor(): ?string
    {
        return $this->photo_author;
    }

    public function setPhotoAuthor(?string $photo_author): self
    {
        $this->photo_author = $photo_author;

        return $this;
    }

    public function getPhotoLink(): ?string
    {
        return $this->photo_link;
    }

    public function setPhotoLink(?string $photo_link): self
    {
        $this->photo_link = $photo_link;

        return $this;
    }

    public function updateFromVRSData($vrsData)
    {
        $this->setCountry($vrsData['Country']);
        $this->setManufacturer($vrsData['Manufacturer']);
        $this->setModel($vrsData['Model']);
        $this->setModelIcao($vrsData['ModelIcao']);
        $this->setOperator($vrsData['Operator']);
        $this->setOperatorIcao($vrsData['OperatorIcao']);
        $this->setRegistration($vrsData['Registration']);
        $this->setSerial($vrsData['Serial']);
        $this->setYearBuild($vrsData['YearBuilt']);
        $this->setLastDataUpdateAt(new \DateTimeImmutable());
    }

    public function updatePhotoFromPlaneSpotters()
    {
        if ($this->getLastPictureUpdateAt() && $this->getLastPictureUpdateAt()->diff(new \DateTimeImmutable())->days < 1) {
            return;
        }
        $url = 'https://www.planespotters.net/api/aircraft/hex/' . $this->getIcao();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output, true);
        if (count($data['photos']) > 0) {
            $this->setPictureUrl($data['data']['photos'][0]['thumbnail_large']['src']);
            $this->setPhotoAuthor($data['data']['photos'][0]['photographer']);
            $this->setPhotoLink($data['data']['photos'][0]['link']);
            $this->setLastPictureUpdateAt(new \DateTimeImmutable());
        }
    }
}
