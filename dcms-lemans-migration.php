<?php
/*
Plugin Name: LMS - WPForms
Plugin URI: https://decodecms.com
Description: Integrates WPForms with LMS for evaluations
Version: 1.0
Author: Jhon Marreros Guzmán
Author URI: https://decodecms.com
Text Domain: dcms-lms-wpforms
Domain Path: languages
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

namespace dcms\wpforms;

require __DIR__ . '/vendor/autoload.php';

use dcms\wpforms\includes\Plugin;
use dcms\wpforms\includes\Submenu;
use dcms\wpforms\includes\Form;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin class to handle settings constants and loading files
 **/
final class Loader {

	// Define all the constants we need
	public function define_constants(): void {
		define( 'DCMS_WPFORMS_VERSION', '1.0' );
		define( 'DCMS_WPFORMS_PATH', plugin_dir_path( __FILE__ ) );
		define( 'DCMS_WPFORMS_URL', plugin_dir_url( __FILE__ ) );
		define( 'DCMS_WPFORMS_BASE_NAME', plugin_basename( __FILE__ ) );
		define( 'DCMS_WPFORMS_SUBMENU', 'tools.php' );
	}

	// Load tex domain
	public function load_domain() {
		add_action( 'plugins_loaded', function () {
			$path_languages = dirname( DCMS_WPFORMS_BASE_NAME ) . '/languages/';
			load_plugin_textdomain( 'dcms-lms-wpforms', false, $path_languages );
		} );
	}

	// Add link to plugin list
	public function add_link_plugin(): void {
		add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), function ( $links ) {
			return array_merge( array(
				'<a href="' . esc_url( admin_url( DCMS_WPFORMS_SUBMENU . '?page=dcms-lms-wpforms' ) ) . '">' . __( 'Settings', 'dcms-lms-wpforms' ) . '</a>'
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
		new Form();
	}
}

$dcms_wpforms_process = new Loader();
$dcms_wpforms_process->init();
