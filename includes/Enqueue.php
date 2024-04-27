<?php

namespace dcms\lms_forms\includes;

use dcms\lms_forms\helpers\FieldGroup;

class Enqueue {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts_backend' ] );
	}

	// Backend scripts
	public function register_scripts_backend(): void {

		// Javascript
		wp_register_script( 'lms-forms-script',
			DCMS_WPFORMS_URL . '/assets/script.js',
			[ 'jquery' ],
			DCMS_WPFORMS_VERSION,
			true );

		wp_localize_script( 'lms-forms-script',
			'lms_forms',
			[
				'documents'       => FieldGroup::get_groups(),
				'entries_url'     => admin_url( 'admin.php?page=wpforms-entries&view=details&entry_id=' ),
				'ajaxurl'         => admin_url( 'admin-ajax.php' ),
				'nonce_lms_forms' => wp_create_nonce( 'ajax-nonce-lms-forms' ),
				'sending'         => __( 'Enviando...', 'dcms-lms-forms' ),
				'processing'      => __( 'Procesando...', 'dcms-lms-forms' )
			] );


		// CSS
		wp_register_style( 'lms-forms-style',
			DCMS_WPFORMS_URL . '/assets/style.css',
			[],
			DCMS_WPFORMS_VERSION );

	}
}