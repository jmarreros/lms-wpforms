<?php

namespace dcms\lms_forms\includes;

use dcms\lms_forms\helpers\FieldGroup;

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
		$groups  = FieldGroup::get_groups();

		include_once( DCMS_WPFORMS_PATH . '/views/configuration.php' );
	}

	// Report page callback, report and report detail view
	public function report_page_callback(): void {
		wp_enqueue_script( 'lms-forms-script' );
		wp_enqueue_style( 'lms-forms-style' );


		$course_id = intval( $_GET['course'] ?? 0 );
		$view      = $_GET['view'] ?? 'report';

		$db = new Database();

		// Main report view
		if ( $view === 'report' ) {
			$courses = $db->get_courses();

			include_once DCMS_WPFORMS_PATH . '/views/report.php';
		} // Detail report view
		elseif ( $view === 'detail' ) {

			// Available document information
			$document_name = $_GET['document_name'] ?? '';
			$documents     = FieldGroup::get_groups();
			$versions      = FieldGroup::get_versions();
			$dates         = FieldGroup::get_dates();
			$end_date      = '';


			if ( ! $document_name || ! in_array( $document_name, $documents ) ) {
				wp_die( 'No valid document selected' );
			}

			// Get report details
			$header_detail = $db->get_item_report_detail( $course_id );

			if ( defined( 'DCMS_COURSE_END_DATE' ) ) {
				$end_date = get_post_meta( $course_id, DCMS_COURSE_END_DATE, true );
			}

			$header_detail['end_date'] = $end_date;

			$ratings    = $db->get_items_report_rating( $course_id, $document_name );
			$checkboxes = $db->get_items_report_checkbox( $course_id, $document_name );

			include_once DCMS_WPFORMS_PATH . '/views/report-detail.php';
		}
	}
}
