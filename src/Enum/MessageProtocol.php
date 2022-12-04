<?php

namespace App\Enum;

class MessageProtocol {
	const ADSB_BASESTATION = 1;

	public static function getChoices(): array {
		return [
			'ADSB BaseStation' => self::ADSB_BASESTATION,
		];
	}

}