<?php

namespace App\Enum;

class BooleanType {
	const YES = 1;
	const NO = 2;

	public static function getChoicesYesNo(): array {
		return [
			'Yes' => self::YES,
			'No'  => self::NO,
		];
	}

	public static function getChoicesActiveInactive(): array {
		return [
			'Active'   => self::YES,
			'Inactive' => self::NO,
		];
	}

}