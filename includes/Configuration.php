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
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'No autorizado.' );
		}

		check_admin_referer( 'dcms_lms_forms_save_ids' );

		$id_form     = absint( $_POST['id_wpform'] ?? 0 );
		$sub_form_id = absint( $_POST['id_sub_wpform_foac05'] ?? 0 );
		$form        = new Form();

		if ( $sub_form_id && ! $form->is_valid_foac05_sub_form( $sub_form_id ) ) {
			wp_safe_redirect( add_query_arg( 'dcms_lms_forms_error', 'invalid-sub-form', admin_url( DCMS_WPFORMS_CONFIGURATION_PAGE ) ) );
			exit();
		}

		update_option( DCMS_WPFORMS_FORM_ID, $id_form );
		update_option( DCMS_WPFORMS_SUB_FORM_ID, $sub_form_id );

		wp_safe_redirect( esc_url( admin_url( DCMS_WPFORMS_CONFIGURATION_PAGE ) ) );
		exit();
	}

	public function lms_forms_save_fields(): void {
		dcms_nonce_verification();

		$fields = $_POST['fields'] ?? [];

		$db = new Database();
		$db->update_fields_configuration( $fields );

		wp_send_json( [ 'message' => 'Fields saved' ] );
	}

}
