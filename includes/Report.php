<?php

namespace dcms\lms_forms\includes;

class Report {

	public function __construct() {
		add_action( 'wp_ajax_dcms_lms_search_entries', [ $this, 'lms_search_entries' ] );
	}

	public function lms_search_entries(): void {
		dcms_nonce_verification();

		$course    = $_POST['course'];
		$date_from = $_POST['dateFrom'];
		$date_to   = $_POST['dateTo'];

		if ( $_POST['dateFrom'] ){
			$date_from = date( 'Y-m-d', strtotime( $_POST['dateFrom'] ) );
		}

		if ( $_POST['dateTo'] ){
			$date_to = date( 'Y-m-d', strtotime( $_POST['dateTo'] ) );
		}

		if ( ! $course ) {
			wp_send_json( [ 'message' => 'Selecciona algún curso' ] );
		}

		$db = new Database();
		$result  = $db->get_entries_report( $course, $date_from, $date_to);

		wp_send_json(
			[
				'message' => 'success',
				'data'  => $result
			]
		);
	}
}