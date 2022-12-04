<?php

namespace App\Protocol\ADSB\BaseStation;

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

	public function __construct( string $raw ) {
		$this->raw                     = $raw;
		$this->icao                    = BaseStationDecoder::getIcao( $raw );
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
	}

	public function getDescription(): string {
		//DEBUG
		return $this->callsign . ' (' . $this->icao . ') ' . $this->altitude . 'ft ' . $this->groundSpeed . 'kt ' . $this->track . '° ' . $this->latitude . ' ' . $this->longitude . ' ' . $this->verticalRate . 'ft/min ' . $this->squawk . ' ' . $this->onGround;
	}


}