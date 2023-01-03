<?php

namespace App\Protocol\ADSB\BaseStation;

use App\Entity\Aircraft;
use App\Entity\AircraftPosition;
use App\Repository\AircraftPositionRepository;
use App\Repository\AircraftRepository;
use App\Utils\CacheUtils;
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
            print_r('Discarded message: No ICAO 1' . "\n");
            return;
        }
        if ($this->icao === '') {
            print_r('Discarded message: No ICAO 2' . "\n");
            return;
        }
        if ($this->icao === '0') {
            print_r('Discarded message: No ICAO 3' . "\n");
            return;
        }
        if (str_starts_with($this->icao, '~')) {
            print_r('Discarded message: Fake ICAO' . "\n");
            return;
        }
        $cache = new CacheUtils();
        $aircraftPositionTimeCache = $cache->read('last_aircraft_position_time_' . $this->icao);
        if ($aircraftPositionTimeCache !== null) {
            print_r('Discarded message: Too recent' . "\n");
            return;

        }
        $cache->write('last_aircraft_position_time_' . $this->icao, '1', 10);

        $this->latitude = BaseStationDecoder::getLatitude($raw);
        $this->longitude = BaseStationDecoder::getLongitude($raw);

        if ($this->latitude === null || $this->longitude === null) {
            print_r('Discarded message: No position' . "\n");
            return;
        }
        $aircraftPositionCache = $cache->read('last_aircraft_position_' . $this->icao);
        if ($aircraftPositionCache !== null) {
            $parts = explode('@', $aircraftPositionCache);
            $lat = $parts[0];
            $lon = $parts[1];
            $distance = BaseStationUtils::getDistanceMeters($this->latitude, $this->longitude, $lat, $lon);
            if ($distance < 500) {
                print_r('Discarded message: Too close to last position, distance: ' . $distance . "\n");
                return;
            }
        }
        $cache->write('last_aircraft_position_' . $this->icao, $this->latitude . '@' . $this->longitude, 60);
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
        return $this->callsign . ' (' . $this->icao . ') ' . $this->altitude . 'ft ' . $this->groundSpeed . 'kt ' . $this->track . '° ' . $this->latitude . ' ' . $this->longitude . ' ' . $this->verticalRate . 'ft/min ' . $this->squawk . ' ' . $this->onGround . "\n";
	}

	private function saveAircraft(): Aircraft {
		$aircraft = $this->aircraftRepository->findOneBy( [ 'icao' => $this->icao ] );
		if ( $aircraft === null ) {
			$aircraft = new Aircraft();
			$aircraft->setIcao( $this->icao );
			$aircraft->setIsMilitary(false);
            $aircraft->setCreatedAt(new DateTimeImmutable());
            $this->aircraftRepository->save($aircraft, true);
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
