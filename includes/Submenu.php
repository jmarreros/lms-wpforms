<?php

namespace dcms\wpforms\includes;

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
			__( 'LMS WpForms integration', 'dcms-lms-wpforms' ),
			__( 'LMS WpForms integration', 'dcms-lms-wpforms' ),
			'manage_options',
			'lms-wpforms',
			[ $this, 'submenu_page_callback' ]
		);
	}

	// Callback, show view
	public function submenu_page_callback(): void {
		$mensaje = mensaje();
		include_once( DCMS_WPFORMS_PATH . '/views/main-screen.php' );
	}
}
