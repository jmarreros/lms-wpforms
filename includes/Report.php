<?php

namespace dcms\lms_forms\includes;

class Report {

	public function __construct() {
		add_action( 'wp_ajax_dcms_lms_search_entries', [ $this, 'lms_search_entries' ] );
	}

	public function lms_search_entries():void{
		error_log(print_r('Reporte!!!',true));
		wp_send_json(['message'=>'']);
	}
}