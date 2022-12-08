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
		$this->icao = BaseStationDecoder::getIcao( $raw );
		if ( $this->icao === null ) {
			return;
		}
		if ( $this->icao === '' ) {
			return;
		}
		if ( $this->icao === '0' ) {
			return;
		}
		$this->transmissionMessageType = BaseStationDecoder::getTransmissionMessageType( $raw );
		$this->callsign                = BaseStationDecoder::getCallsign( $raw );
		$this->altitude                = BaseStationDecoder::getAltitude( $raw );
		$this->groundSpeed             = BaseStationDecoder::getGroundSpeed( $raw );
		$this->track                   = BaseStationDecoder::getTrack( $raw );
		$this->latitude                = BaseStationDecoder::getLatitude( $raw );
		$this->longitude               = BaseStationDecoder::getLongitude( $raw );
		$this->verticalRate            = BaseStationDecoder::getVerticalRate( $raw );
		$this->squawk                  = BaseStationDecoder::getSquawk( $raw );
		$this->onGround                = BaseStationDecoder::getOnGround( $raw );

		$this->aircraft = $this->saveAircraft();
		$this->saveAircraftPosition( $this->aircraft );

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

	private function saveAircraftPosition( Aircraft $aircraft ): void {
		$aircraftPosition = new AircraftPosition();
		$aircraftPosition->setAircraft( $aircraft );
		$aircraftPosition->setPositionAt( new DateTimeImmutable() );
		$aircraftPosition->setLatitude( $this->latitude );
		$aircraftPosition->setLongitude( $this->longitude );
		$aircraftPosition->setTrack( $this->track );
		$aircraftPosition->setVerticalRate( $this->verticalRate );
		$aircraftPosition->setSquawk( $this->squawk );
		$this->aircraftPositionRepository->save( $aircraftPosition, true );
	}


}