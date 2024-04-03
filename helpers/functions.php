<?php

// Return array like
//[
//  51 => [
//    "name" => "course_id",
//    "value" => "110071,",
//    "id" => 51,
//    "type" => "hidden",
//  ],
//]
function filter_from_fields( $value_search, $fields ): array {
	return array_filter( $fields, function ( $value ) use ( $value_search ) {
		return $value['name'] === $value_search;
	} );
}
