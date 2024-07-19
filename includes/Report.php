<?php

namespace dcms\lms_forms\includes;

class Report {

	public function __construct() {
		add_action( 'wp_ajax_dcms_lms_search_courses', [ $this, 'lms_search_courses' ] );
		add_action( 'wp_ajax_dcms_lms_search_entries', [ $this, 'lms_search_entries' ] );

		add_action( 'wp_ajax_dcms_lms_search_courses_weighted', [ $this, 'lms_search_courses_weighted' ] );
	}


	public function lms_search_courses(): void {
		dcms_nonce_verification();
		$dates = $this->get_dates_from_post();

		$db      = new Database();
		$courses = $db->get_courses( $dates['from'], $dates['to'] );

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

	public function lms_search_courses_weighted(): void {
		dcms_nonce_verification();

		$dates = $this->get_dates_from_post();

		$db      = new Database();
		$courses = $db->get_courses_weighted( $dates['from'], $dates['to'] );

		wp_send_json_success( $courses );
	}


	private function get_dates_from_post(): array {
		$date_from = $_POST['dateFrom'] ?? null;
		$date_to   = $_POST['dateTo'] ?? null;

		if ( $date_from ) {
			$date_from = date( 'Y-m-d', strtotime( $date_from ) );
		}

		if ( $date_to ) {
			$date_to = date( 'Y-m-d', strtotime( $date_to ) );
		}

		return [
			'from' => $date_from,
			'to'   => $date_to
		];
	}
}