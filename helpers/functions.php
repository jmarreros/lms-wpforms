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

function dcms_nonce_verification(): void {
	$nonce = $_POST['nonce'];
	if ( ! wp_verify_nonce( $nonce, 'ajax-nonce-lms-forms' ) ) {
		wp_send_json( [ 'message' => 'Nonce error' ] );
	}
}