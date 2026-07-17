<?php

namespace dcms\lms_forms\includes;

use dcms\lms_forms\helpers\FieldGroup;

class Enqueue {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts_backend' ] );
	}

	// Backend scripts
	public function register_scripts_backend(): void {
		$report_forms = [ absint( get_option( DCMS_WPFORMS_FORM_ID, 0 ) ) => 'Formulario Genérico' ];
		$sub_form_id  = absint( get_option( DCMS_WPFORMS_SUB_FORM_ID, 0 ) );
		if ( $sub_form_id ) {
			$report_forms[ $sub_form_id ] = 'Formulario Facilitadores';
		}

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
				'entries_url'     => admin_url( 'admin.php' ),
				'ajaxurl'         => admin_url( 'admin-ajax.php' ),
				'nonce_lms_forms' => wp_create_nonce( 'ajax-nonce-lms-forms' ),
				'sending'         => __( 'Enviando...', 'dcms-lms-forms' ),
				'processing'      => __( 'Procesando...', 'dcms-lms-forms' ),
				'report_forms'    => $report_forms,
			] );


		// CSS
		wp_register_style( 'lms-forms-style',
			DCMS_WPFORMS_URL . '/assets/style.css',
			[],
			DCMS_WPFORMS_VERSION );

	}
}
