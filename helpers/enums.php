<?php

namespace dcms\lms_forms\helpers;
abstract class FieldType
{
	const Rating = 'rating';
	const Checkbox = 'checkbox';
	const Textarea = 'textarea';
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
}

