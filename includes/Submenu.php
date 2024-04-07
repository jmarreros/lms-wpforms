<?php

namespace dcms\lms_forms\includes;

use dcms\lms_forms\helpers\FieldGroup;
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
			[ $this, 'main_page_callback' ]
		);

		add_submenu_page(
			'wpforms-overview',
			esc_html__( 'Reporte Evaluaciones', 'wpforms-lite' ),
			esc_html__( 'Reporte Evaluaciones', 'wpforms-lite' ),
			'manage_options',
			'dcms-lms-forms-report',
			[ $this, 'report_page_callback' ],
			0
		);
	}

	// Callback, show main view
	public function main_page_callback(): void {
		wp_enqueue_script( 'lms-forms-script' );
		wp_enqueue_style( 'lms-forms-style' );

		$form    = new Form();
		$id_form = get_option( DCMS_WPFORMS_FORM_ID, 0 );
		$fields  = $form->get_fields_configuration();
		$groups = FieldGroup::get_groups();

		include_once( DCMS_WPFORMS_PATH . '/views/main-screen.php' );
	}

	// Report page callback
	public function report_page_callback(): void {
		wp_enqueue_script( 'lms-forms-script' );
		wp_enqueue_style( 'lms-forms-style' );

		$db = new Database();
		$courses = $db->get_courses();

		include_once( DCMS_WPFORMS_PATH . '/views/report.php' );
	}
}
