<?php

namespace dcms\wpforms\includes;

class Database {
	private \wpdb $wpdb;
	private string $table_items;
	private string $table_item_detail;

	public function __construct() {
		global $wpdb;

		$this->wpdb              = $wpdb;
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
                    entry_id bigint(20) NOT NULL,
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
                    field_id smallint NOT NULL,
                    field_label varchar(255) NOT NULL,
                    field_value varchar(255) NOT NULL,
                    field_group varchar(10) NOT NULL,
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
}