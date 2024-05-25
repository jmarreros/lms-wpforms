<?php
/*
Plugin Name: LMS - Forms
Plugin URI: https://decodecms.com
Description: Integrates WPForms with LMS for evaluations
Version: 1.1
Author: Jhon Marreros Guzmán
Author URI: https://decodecms.com
Text Domain: dcms-lms-forms
Domain Path: languages
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

namespace dcms\lms_forms;

require __DIR__ . '/vendor/autoload.php';

use dcms\lms_forms\includes\Plugin;
use dcms\lms_forms\includes\Submenu;
use dcms\lms_forms\includes\Form;
use dcms\lms_forms\includes\Configuration;
use dcms\lms_forms\includes\Enqueue;
use dcms\lms_forms\includes\Report;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin class to handle settings constants and loading files
 **/
final class Loader {

	// Define all the constants we need
	public function define_constants(): void {
		define( 'DCMS_WPFORMS_VERSION', '1.1' );
		define( 'DCMS_WPFORMS_PATH', plugin_dir_path( __FILE__ ) );
		define( 'DCMS_WPFORMS_URL', plugin_dir_url( __FILE__ ) );
		define( 'DCMS_WPFORMS_BASE_NAME', plugin_basename( __FILE__ ) );
		define( 'DCMS_WPFORMS_SUBMENU', 'options-general.php' );
		define( 'DCMS_WPFORMS_CONFIGURATION_PAGE', DCMS_WPFORMS_SUBMENU . '?page=dcms-lms-forms' );
		define( 'DCMS_WPFORMS_FORM_ID', 'dcms_lms_forms_id_form' );
//		define( 'DCMS_WPFORMS_MINIMUM_DATE_COURSES', '2024-03-01'); // Date to filter courses, to start new functionality
	}

	// Load tex domain
	public function load_domain(): void {
		add_action( 'plugins_loaded', function () {
			$path_languages = dirname( DCMS_WPFORMS_BASE_NAME ) . '/languages/';
			load_plugin_textdomain( 'dcms-lms-forms', false, $path_languages );
		} );
	}

	// Add link to plugin list
	public function add_link_plugin(): void {
		add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), function ( $links ) {
			return array_merge( array(
				'<a href="' . esc_url( admin_url( DCMS_WPFORMS_CONFIGURATION_PAGE ) ) . '">' . __( 'Settings', 'dcms-lms-forms' ) . '</a>'
			), $links );
		} );
	}

	// Initialize all
	public function init(): void {
		$this->define_constants();
		$this->load_domain();
		$this->add_link_plugin();
		new Plugin();
		new SubMenu();
		new Enqueue();
		new Form();
		new Configuration();
		new Report();
	}
}

$dcms_wpforms_process = new Loader();
$dcms_wpforms_process->init();
