<?php

namespace dcms\lms_forms\helpers;
abstract class FieldType
{
	const Text = 0;
	const Selection = 1;
	const Comment = 2;
}

function mensaje(): string {
	return "Hola desde helper";
}