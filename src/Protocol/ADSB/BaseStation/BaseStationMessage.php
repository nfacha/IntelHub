<?php

namespace App\Protocol\ADSB\BaseStation;

use App\Entity\Aircraft;
use App\Entity\AircraftPosition;
use App\Repository\AircraftPositionRepository;
use App\Repository\AircraftRepository;
use DateTimeImmutable;

class BaseStationMessage {
	public $raw;
	public $icao;
	public $transmissionMessageType;
	public $callsign;
	public $altitude;
	public $groundSpeed;
	public $track;
	public $latitude;
	public $longitude;
	public $verticalRate;
	public $squawk;
	public $onGround;

	private $aircraftRepository;
	private $aircraftPositionRepository;

	private $aircraft;

	public function __construct( string $raw, AircraftRepository $aircraftRepository, AircraftPositionRepository $aircraftPositionRepository ) {
		if ( ! BaseStationUtils::isAdsbMessage( $raw ) ) {
			return;
		}
		if ( BaseStationDecoder::getMessageType( $raw ) !== 'MSG' ) {
			return;
		}
		$this->aircraftRepository         = $aircraftRepository;
		$this->aircraftPositionRepository = $aircraftPositionRepository;

		$this->raw  = $raw;
        $this->icao = BaseStationDecoder::getIcao($raw);
        if ($this->icao === null) {
            print_r('Discarded message: No ICAO 1');
            return;
        }
        if ($this->icao === '') {
            print_r('Discarded message: No ICAO 2');
            return;
        }
        if ($this->icao === '0') {
            print_r('Discarded message: No ICAO 3');
            return;
        }
        if (str_starts_with($this->icao, '~')) {
            print_r('Discarded message: Fake ICAO');
            return;
        }

        $lastAircraftPosition = $this->aircraftPositionRepository->findOneBy(['icao' => $this->icao], ['position_at' => 'DESC']);
        if ($lastAircraftPosition !== null) {
            $now = new DateTimeImmutable();
            $diff = $now->getTimestamp() - $lastAircraftPosition->getPositionAt()->getTimestamp();
            if ($diff < 10) {
                print_r('Discarded message: Too recent');
                return;
            }
        }

        $this->latitude = BaseStationDecoder::getLatitude($raw);
        $this->longitude = BaseStationDecoder::getLongitude($raw);

        if ($this->latitude === null || $this->longitude === null) {
            print_r('Discarded message: No position');
            return;
        }
        //if position is less than 1km from last position, discard
        if ($lastAircraftPosition !== null) {
            $distance = BaseStationUtils::getDistanceMeters($this->latitude, $this->longitude, $lastAircraftPosition->getLatitude(), $lastAircraftPosition->getLongitude());
            if ($distance < 500) {
                print_r('Discarded message: Too close to last position');
                return;
            }
        }
        $this->transmissionMessageType = BaseStationDecoder::getTransmissionMessageType($raw);
        $this->callsign = BaseStationDecoder::getCallsign($raw);
        $this->altitude = BaseStationDecoder::getAltitude($raw);
        $this->groundSpeed = BaseStationDecoder::getGroundSpeed($raw);
        $this->track = BaseStationDecoder::getTrack($raw);
        $this->verticalRate = BaseStationDecoder::getVerticalRate($raw);
        $this->squawk = BaseStationDecoder::getSquawk($raw);
        $this->onGround = BaseStationDecoder::getOnGround($raw);

        $this->saveAircraft();
        $this->saveAircraftPosition();

    }

	public function getDescription(): string {
		//DEBUG
		return $this->callsign . ' (' . $this->icao . ') ' . $this->altitude . 'ft ' . $this->groundSpeed . 'kt ' . $this->track . '° ' . $this->latitude . ' ' . $this->longitude . ' ' . $this->verticalRate . 'ft/min ' . $this->squawk . ' ' . $this->onGround;
	}

	private function saveAircraft(): Aircraft {
		$aircraft = $this->aircraftRepository->findOneBy( [ 'icao' => $this->icao ] );
		if ( $aircraft === null ) {
			$aircraft = new Aircraft();
			$aircraft->setIcao( $this->icao );
			$aircraft->setIsMilitary( false );
			$this->aircraftRepository->save( $aircraft, true );
		}

		return $aircraft;
	}

    private function saveAircraftPosition(): void
    {
        $aircraftPosition = new AircraftPosition();
        $aircraftPosition->setIcao($this->icao);
        $aircraftPosition->setPositionAt(new DateTimeImmutable());
        $aircraftPosition->setLatitude($this->latitude);
        $aircraftPosition->setLongitude($this->longitude);
        $aircraftPosition->setTrack($this->track);
        $aircraftPosition->setVerticalRate($this->verticalRate);
        $aircraftPosition->setSquawk($this->squawk);
        $this->aircraftPositionRepository->save($aircraftPosition, true);
    }


}
