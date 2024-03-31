<?php

namespace dcms\lms_forms\includes;

class Database {
	private \wpdb $wpdb;
	private string $table_items;
	private string $table_item_detail;
	private string $table_fields;

	public function __construct() {
		global $wpdb;

		$this->wpdb              = $wpdb;
		$this->table_fields      = $this->wpdb->prefix . 'lms_wpform_fields';
		$this->table_items       = $this->wpdb->prefix . 'lms_wpform_items';
		$this->table_item_detail = $this->wpdb->prefix . 'lms_wpform_item_details';
	}

	// Create table item
	public function create_table_items(): void {
		$sql = "CREATE TABLE IF NOT EXISTS $this->table_items (
    				id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    user_id bigint(20) NOT NULL,
                    course_id bigint(20) NOT NULL,
                    author_id bigint(20) NOT NULL,
                    entry_id_wpforms bigint(20) NOT NULL,
                    total_foac04 smallint NOT NULL,
                    total_foac05 smallint NOT NULL,
                    total_foac06 smallint NOT NULL,
                    updated datetime default CURRENT_TIMESTAMP,
                    PRIMARY KEY (id)
                ) {$this->wpdb->get_charset_collate()};";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	// Create table item details
	public function create_table_item_details(): void {
		$sql = "CREATE TABLE IF NOT EXISTS $this->table_item_detail (
    				id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    id_item bigint(20) NOT NULL,
                    field_id int NOT NULL,
                    field_value text NOT NULL,
                    PRIMARY KEY (id)
                ) {$this->wpdb->get_charset_collate()};";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}


	// Template table fields to related with WPForms field ids
	public function create_table_fields(): void {
		$sql = "CREATE TABLE IF NOT EXISTS $this->table_fields (
    				id int unsigned NOT NULL AUTO_INCREMENT,
                    field_label varchar(250) NULL,
                    field_id_wpforms smallint NOT NULL,
                    field_group varchar(10) NULL,
                    field_type varchar(20) NULL,
                    field_options varchar(250) NULL,
                    field_order smallint NOT NULL,
                    is_active tinyint(1) NOT NULL DEFAULT 1,
                    updated datetime default CURRENT_TIMESTAMP,
                    PRIMARY KEY (id)
                ) {$this->wpdb->get_charset_collate()};";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}


	public function get_lesson_data( $lesson_id ): array {
		$lessons_table = $this->wpdb->prefix . 'stm_lms_user_lessons';
		$post_table    = $this->wpdb->posts;

		$sql = "SELECT l.course_id course_id, p.post_author author_id 
				FROM $lessons_table l
				INNER JOIN $post_table p ON l.course_id = p.ID 
				WHERE l.lesson_id = $lesson_id";

		return $this->wpdb->get_row( $sql, ARRAY_A );
	}

	// Get item data by user and course
	public function get_item_data( $user_id, $course_id ): array {
		$sql = "SELECT * FROM $this->table_items 
         		WHERE user_id = $user_id AND course_id = $course_id";

		return $this->wpdb->get_row( $sql, ARRAY_A ) ?? [];
	}

	public function get_wpforms_content( $id_wpforms ): string {
		$post_table = $this->wpdb->posts;

		$sql = "SELECT post_content FROM $post_table
				WHERE ID = $id_wpforms";

		return $this->wpdb->get_var( $sql ) ?? '';
	}

	// Get fields saved in configuration from database
	public function get_fields(): array {
		$sql = "SELECT * FROM $this->table_fields 
         		WHERE is_active = 1 AND field_group<>'' 
         		ORDER BY field_group, field_order";

		return $this->wpdb->get_results( $sql, ARRAY_A ) ?? [];
	}

}