<?php

namespace dcms\lms_forms\includes;

use dcms\lms_forms\helpers\FieldType;

/**
 * Class for creating a dashboard submenu
 */
class Submenu {

	// Constructor
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'register_submenu' ] );
	}

	// Register submenu
	public function register_submenu(): void {
		add_submenu_page(
			DCMS_WPFORMS_SUBMENU,
			__( 'LMS WpForms integration', 'dcms-lms-forms' ),
			__( 'LMS WpForms integration', 'dcms-lms-forms' ),
			'manage_options',
			'dcms-lms-forms',
			[ $this, 'submenu_page_callback' ]
		);
	}

	// Callback, show view
	public function submenu_page_callback(): void {
		wp_enqueue_script( 'lms-forms-script' );
		wp_enqueue_style( 'lms-forms-style' );

		$form    = new Form();
		$id_form = get_option( DCMS_WPFORMS_FORM_ID, 0 );
		$fields  = $form->get_fields_configuration();

		error_log( print_r( $fields, true ) );

		include_once( DCMS_WPFORMS_PATH . '/views/main-screen.php' );
	}
}
