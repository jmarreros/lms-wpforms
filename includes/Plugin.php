<?php

namespace dcms\lms_forms\includes;

class Plugin {

	public function __construct() {
		register_activation_hook( DCMS_WPFORMS_BASE_NAME, [ $this, 'dcms_activation_plugin' ] );
		register_deactivation_hook( DCMS_WPFORMS_BASE_NAME, [ $this, 'dcms_deactivation_plugin' ] );
	}

	// Activate plugin - create options and database table
	public function dcms_activation_plugin():void {
		// Create tables
		$db = new Database();
		$db->create_table_items();
		$db->create_table_item_details();
		$db->create_table_fields();
	}


	// Deactivate plugin
	public function dcms_deactivation_plugin():void {
	}
}
