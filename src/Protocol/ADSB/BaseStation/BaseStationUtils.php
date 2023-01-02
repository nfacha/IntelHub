<?php

namespace App\Protocol\ADSB\BaseStation;

class BaseStationUtils {
	public static function parseMsg( string $msg ) {
		return explode( ',', $msg );
	}

	public static function isAdsbMessage( string $message ): bool {
		// Check if the message is a valid ADS-B message
		if ( str_starts_with( $message, "###" ) ) {
			return false;
		}

		return true;
	}

	public static function hex2Bin( string $hex ): string {
		$bin = '';
		for ( $i = 0; $i < strlen( $hex ); $i ++ ) {
			$bin .= str_pad( decbin( hexdec( $hex[ $i ] ) ), 4, '0', STR_PAD_LEFT );
		}

		return $bin;
	}

	public static function bin2Hex( string $bin ): string {
		$hex = '';
		for ( $i = 0; $i < strlen( $bin ); $i += 4 ) {
			$hex .= dechex( bindec( substr( $bin, $i, 4 ) ) );
		}

		return $hex;
	}

	public static function bin2Dec( string $bin ): int {
		return bindec( $bin );
	}

	public static function bin2Str( string $bin ): string {
		$str = '';
		for ( $i = 0; $i < strlen( $bin ); $i += 8 ) {
			$str .= chr( bindec( substr( $bin, $i, 8 ) ) );
		}

		return $str;
	}

	public static function convertNumberBase( string $number, int $fromBase, int $toBase ): string {
		$chars = '0123456789abcdefghijklmnopqrstuvwxyz';
		$toStr = substr( $chars, 0, $toBase );

		$length = strlen( $number );
		$result = '';
		for ( $i = 0; $i < $length; $i ++ ) {
			$number[ $i ] = strpos( $chars, $number[ $i ] );
		}
		do {
			$divide = 0;
			$newlen = 0;
			for ( $i = 0; $i < $length; $i ++ ) {
				$divide = $divide * $fromBase + $number[ $i ];
				if ( $divide >= $toBase ) {
					$number[ $newlen ++ ] = (int) ( $divide / $toBase );
					$divide               = $divide % $toBase;
				} elseif ( $newlen > 0 ) {
					$number[ $newlen ++ ] = 0;
				}
			}
			$length = $newlen;
			$result = $toStr[ $divide ] . $result;
		} while ( $newlen != 0 );

		return $result;
	}

    public static function gray2Dec(string $gray): int
    {
        $bin = '';
        $bin .= $gray[0];
        for ($i = 1; $i < strlen($gray); $i++) {
            $bin .= $gray[$i] ^ $gray[$i - 1];
        }

        return bindec($bin);
    }

    public static function getDistanceMeters(?string $latitude, ?string $longitude, ?string $getLatitude, ?string $getLongitude)
    {
        if (is_null($latitude) || is_null($longitude) || is_null($getLatitude) || is_null($getLongitude)) {
            return 9999999999;
        }

        $earthRadius = 6371000; // meters

        $dLat = deg2rad($getLatitude - $latitude);
        $dLon = deg2rad($getLongitude - $longitude);

        $lat1 = deg2rad($latitude);
        $lat2 = deg2rad($getLatitude);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            sin($dLon / 2) * sin($dLon / 2) * cos($lat1) * cos($lat2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = $earthRadius * $c;

        return $d;

    }


}
