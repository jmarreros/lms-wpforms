<?php

namespace dcms\lms_forms\helpers;
abstract class FieldType
{
	const Rating = 'rating';
	const Checkbox = 'checkbox';
	const Textarea = 'textarea';
}

abstract class Rating{
	const RATING_VALUES = [
		1 => 0,
		2 => 0.2,
		3 => 0.5,
		4 => 0.7,
		5 => 1
	];
}

abstract class FieldGroup
{
	const FO_AC_04 = 'FO-AC-04';
	const FO_AC_05 = 'FO-AC-05';
	const FO_AC_06 = 'FO-AC-06';

	public  static function get_groups(): array {
		return [
			self::FO_AC_04,
			self::FO_AC_05,
			self::FO_AC_06
		];
	}

	public static function get_versions():array{
		return [
			self::FO_AC_04 => '3.0',
			self::FO_AC_05 => '2.0',
			self::FO_AC_06 => '2.0'
		];
	}

	public static function get_titles():array{
		return [
			self::FO_AC_04 => 'EVALUACIÓN ACCIÓN FORMATIVA',
			self::FO_AC_05 => 'EVALUACIÓN FORMADOR',
			self::FO_AC_06 => 'EVALUACIÓN ATENCIÓN AL PARTICIPANTE'
		];
	}

	public static function get_dates():array{
		return [
			self::FO_AC_04 => '26-01-2024',
			self::FO_AC_05 => '17-01-2024',
			self::FO_AC_06 => '17-01-2024'
		];
	}

}

