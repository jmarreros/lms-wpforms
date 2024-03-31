<?php

namespace dcms\lms_forms\includes;

use JetBrains\PhpStorm\NoReturn;

class Configuration {

	public function __construct() {
		add_action( 'admin_post_save_id_form', [ $this, 'save_id_form' ] );
		add_action( 'wp_ajax_dcms_lms_forms_save_fields', [ $this, 'lms_forms_save_fields' ] );
	}

	#[NoReturn]
	public function save_id_form(): void {
		$id_form = (int) $_POST['id_wpform'];
		update_option( DCMS_WPFORMS_FORM_ID, $id_form );

		wp_safe_redirect( esc_url( admin_url( DCMS_WPFORMS_CONFIGURATION_PAGE ) ) );
		exit();
	}

	public function lms_forms_save_fields(): void {
		$this->nonce_verification();

		$fields = $_POST['fields'] ?? [];

		$db = new Database();
		$db->update_fields_configuration( $fields );

		wp_send_json( [ 'message' => 'Fields saved' ] );
	}

	private function nonce_verification(): void {
		$nonce = $_POST['nonce'];
		if ( ! wp_verify_nonce( $nonce, 'ajax-nonce-lms-forms' ) ) {
			wp_send_json( [ 'message' => 'Nonce error' ] );
		}
	}
}