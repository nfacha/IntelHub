<?php

namespace App\Protocol\ADSB\BaseStation;

use Exception;

class BaseStationDecoder {

	public static function getMessageType( string $msg ) {
		try {
			return BaseStationUtils::parseMsg( $msg )[0];

		} catch ( Exception $e ) {
			return null;
		}
	}

	public static function getTransmissionMessageType( string $msg ) {
		try {
			return BaseStationUtils::parseMsg( $msg )[1];

		} catch ( Exception $e ) {
			return null;
		}
	}

	public static function getIcao( string $msg ) {
		try {
			return BaseStationUtils::parseMsg( $msg )[4];

		} catch ( Exception $e ) {
			return null;
		}
	}

	public static function getCallsign( string $msg ) {
		try {
			return BaseStationUtils::parseMsg( $msg )[10];

		} catch ( Exception $e ) {
			return null;
		}
	}

	public static function getAltitude( string $msg ) {
		try {
			return BaseStationUtils::parseMsg( $msg )[11];

		} catch ( Exception $e ) {
			return null;
		}
	}

	public static function getGroundSpeed( string $msg ) {
		try {
			return BaseStationUtils::parseMsg( $msg )[12];

		} catch ( Exception $e ) {
			return null;
		}
	}

	public static function getTrack( string $msg ) {
		try {
			return BaseStationUtils::parseMsg( $msg )[13];

		} catch ( Exception $e ) {
			return null;
		}
	}

	public static function getLatitude( string $msg ) {
		try {
			return BaseStationUtils::parseMsg( $msg )[14];

		} catch ( Exception $e ) {
			return null;
		}
	}

	public static function getLongitude( string $msg ) {
		try {
			return BaseStationUtils::parseMsg( $msg )[15];

		} catch ( Exception $e ) {
			return null;
		}
	}

	public static function getVerticalRate( string $msg ) {
		try {
			return (int) BaseStationUtils::parseMsg( $msg )[16];

		} catch ( Exception $e ) {
			return null;
		}
	}

	public static function getSquawk( string $msg ) {
		try {
			return BaseStationUtils::parseMsg( $msg )[17];

		} catch ( Exception $e ) {
			return null;
		}
	}

	public static function getOnGround( string $msg ) {
		try {
			return (int) BaseStationUtils::parseMsg( $msg )[20] === - 1;
		} catch ( Exception $e ) {
			return null;
		}
	}
}