<?php

namespace App\Enum;

class SourceType {
	const PUSH_SOURCE = 1;
	const PULL_SOURCE = 2;

	public static function getChoices(): array {
		return [
			self::PUSH_SOURCE => 'Push Source',
			self::PULL_SOURCE => 'Pull Source',
		];
	}

}