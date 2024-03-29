<?php

namespace dcms\lms_forms\includes;

use JetBrains\PhpStorm\NoReturn;

class Configuration {

	public function __construct() {
		add_action( 'admin_post_save_id_form', [ $this, 'save_id_form' ] );
	}

	#[NoReturn] public function save_id_form(): void {
		$id_form = (int) $_POST['id_wpform'];
		update_option( DCMS_WPFORMS_FORM_ID, $id_form );

		wp_safe_redirect( esc_url( admin_url( DCMS_WPFORMS_CONFIGURATION_PAGE ) ) );
		exit();
	}
}