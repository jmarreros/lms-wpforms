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
//		$x = FieldType::Comment;
		$id_form = get_option( DCMS_WPFORMS_FORM_ID, 0 );
		include_once( DCMS_WPFORMS_PATH . '/views/main-screen.php' );
	}
}
