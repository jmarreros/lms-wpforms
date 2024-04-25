<?php

namespace dcms\lms_forms\includes;

class Report {

	public function __construct() {
		add_action( 'wp_ajax_dcms_lms_search_entries', [ $this, 'lms_search_entries' ] );
	}

	public function lms_search_entries(): void {
		dcms_nonce_verification();

		$course    = $_POST['course'];

		if ( ! $course ) {
			wp_send_json( [ 'message' => 'Selecciona algún curso' ] );
		}

		$db = new Database();
		$result  = $db->get_entries_report( $course);

		wp_send_json(
			[
				'message' => 'success',
				'data'  => $result
			]
		);
	}
}