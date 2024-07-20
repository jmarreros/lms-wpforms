<?php

namespace dcms\lms_forms\includes;

use JetBrains\PhpStorm\NoReturn;

class Report {

	public function __construct() {
		add_action( 'wp_ajax_dcms_lms_search_courses', [ $this, 'lms_search_courses' ] );
		add_action( 'wp_ajax_dcms_lms_search_entries', [ $this, 'lms_search_entries' ] );

		add_action( 'admin_post_process_weighted_report', [ $this, 'lms_redirect_report_weighted' ] );
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

	// To add dates to url and redirect
	public function lms_redirect_report_weighted(): void {
		$dates = $this->get_dates_from_post();

		//Add date to origen url and redirect
		$url_origen = $_SERVER['HTTP_REFERER'] . '&dateFrom=' . $dates['from'] . '&dateTo=' . $dates['to'];
		wp_redirect( $url_origen );
		exit;
	}

	// Auxiliar function to get dates from POST request
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