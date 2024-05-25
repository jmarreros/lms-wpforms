<?php

namespace dcms\lms_forms\includes;

class Report {

	public function __construct() {
		add_action( 'wp_ajax_dcms_lms_search_courses', [ $this, 'lms_search_courses' ] );
		add_action( 'wp_ajax_dcms_lms_search_entries', [ $this, 'lms_search_entries' ] );
	}


	public function lms_search_courses(): void {
		dcms_nonce_verification();

		$date_from = $_POST['dateFrom'] ?? null;
		$date_to   = $_POST['dateTo'] ?? null;

		if ( $date_from ) {
			$date_from = date( 'Y-m-d', strtotime( $date_from ) );
		}

		if ( $date_to ) {
			$date_to = date( 'Y-m-d', strtotime( $date_to ) );
		}

		$db      = new Database();
		$courses = $db->get_courses( $date_from, $date_to );

		wp_send_json_success( $courses );
	}

	public function lms_search_entries(): void {
		dcms_nonce_verification();

		$course = $_POST['course'];

		if ( ! $course ) {
			wp_send_json( [ 'message' => 'Selecciona algún curso' ] );
		}

		$db     = new Database();
		$result = $db->get_entries_report( $course );

		wp_send_json(
			[
				'message' => 'success',
				'data'    => $result
			]
		);
	}
}