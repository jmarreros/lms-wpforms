<?php
$current_item     = $_GET['item'] ?? '';
$current_document = $_GET['document'] ?? '';

if ( ! $current_item ) {
	include_once DCMS_WPFORMS_PATH . '/views/report.php';
} else {

	// Validate document
	$documents = \dcms\lms_forms\helpers\FieldGroup::get_groups();
	if ( ! $current_document || ! in_array( $current_document, $documents ) ) {
		wp_die( 'No valid document selected' );
	}

	include_once DCMS_WPFORMS_PATH . '/views/report-detail.php';
}