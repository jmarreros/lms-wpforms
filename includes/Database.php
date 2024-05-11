<?php

namespace dcms\lms_forms\includes;

use wpdb;

class Database {
	private wpdb $wpdb;
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
                    field_id_wpforms smallint NOT NULL,
                    field_label varchar(250) NULL,
                    field_group varchar(10) NULL,
                    field_type varchar(20) NULL,
                    field_options varchar(250) NULL,
                    field_order smallint NOT NULL,
                    is_active tinyint(1) NOT NULL DEFAULT 1,
                    updated datetime default CURRENT_TIMESTAMP,
                    PRIMARY KEY (field_id_wpforms)
                ) {$this->wpdb->get_charset_collate()};";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}


	public function get_course_data_by_lesson( $lesson_id ): array {
		$lessons_table = $this->wpdb->prefix . 'stm_lms_user_lessons';
		$post_table    = $this->wpdb->posts;
		$user_table    = $this->wpdb->users;

		$sql = "SELECT 
				l.course_id course_id, 
				p.post_title course_name,
				p.post_author author_id,
				u.display_name author_name
				FROM $lessons_table l
				INNER JOIN $post_table p ON l.course_id = p.ID 
				INNER JOIN $user_table u ON p.post_author = u.ID
				WHERE l.lesson_id = $lesson_id";

		return $this->wpdb->get_row( $sql, ARRAY_A );
	}

	public function get_course_data( $course_id ): array {
		$post_table = $this->wpdb->posts;
		$user_table = $this->wpdb->users;

		$sql = "SELECT
				p.ID course_id,
				p.post_title course_name,
				p.post_author author_id,
				u.display_name author_name
				FROM $post_table p 
				INNER JOIN $user_table u ON p.post_author = u.ID
				WHERE p.ID = $course_id";

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


	public function update_fields_configuration( $fields ): void {
		if ( empty( $fields ) ) {
			return;
		}

		foreach ( $fields as $field ) {
			$data = [
				'field_id_wpforms' => $field['id'],
				'field_label'      => $field['label'],
				'field_group'      => $field['document'],
				'field_type'       => $field['type'],
				'field_options'    => $field['options'],
				'field_order'      => $field['order'],
			];
			$this->wpdb->replace( $this->table_fields, $data );
		}
	}

	// Save items entry in custom lms_wpform_items table
	public function save_items_fields( $item, $item_details ): void {
		$this->wpdb->insert( $this->table_items, $item );
		$id = $this->wpdb->insert_id;

		foreach ( $item_details as $detail ) {
			$detail['id_item'] = $id;
			$this->wpdb->insert( $this->table_item_detail, $detail );
		}

	}

	// Get active courses
	public function get_courses(): array {
		$post_table = $this->wpdb->posts;

		$sql = "SELECT DISTINCT i.course_id, c.post_title course_name, DATE(c.post_date) created 
				FROM $this->table_items i
				INNER JOIN $post_table c ON i.course_id = c.ID 
				ORDER BY course_name, created DESC";

		return $this->wpdb->get_results( $sql, ARRAY_A ) ?? [];
	}


	// Get items details by item id
	public function get_entries_report( $id_course ): array {
		$post_table   = $this->wpdb->posts;
		$user_table   = $this->wpdb->users;
		$author_table = $this->wpdb->users;

		$sql = "SELECT DATE_FORMAT(i.updated, '%d/%m/%Y') updated,
       				i.entry_id_wpforms,
       				u.display_name user_name, 
       				c.post_title course_name,
       				a.display_name author_name
				FROM $this->table_items i
				INNER JOIN $user_table u ON i.user_id = u.ID
				INNER JOIN $post_table c ON i.course_id = c.ID
				INNER JOIN $author_table a ON i.author_id = a.ID
				WHERE i.course_id = $id_course";
		
		error_log(print_r($sql,true));

		return $this->wpdb->get_results( $sql, ARRAY_A ) ?? [];
	}

	// Get header detail for report
	public function get_item_report_detail( $course_id ): array {
		$post_table = $this->wpdb->posts;
		$user_table = $this->wpdb->users;

		$sql = "SELECT 
    				DISTINCT 
    				p.post_title course_name, 
                	a.display_name author_name 
				FROM $this->table_items i
				INNER JOIN $user_table a ON a.ID = i.author_id 
				INNER JOIN $post_table p ON p.ID = i.course_id
				WHERE course_id = $course_id";

		return $this->wpdb->get_row( $sql, ARRAY_A ) ?? [];
	}

	// Get items rating type fields for reporting
	public function get_items_report_rating( $course_id, $document ): array {
		$sql = "SELECT 
					f.field_label,
					field_value
				FROM $this->table_fields  f
				INNER JOIN $this->table_item_detail d ON f.field_id_wpforms = d.field_id
				INNER JOIN $this->table_items i ON i.id = d.id_item
				WHERE 
					i.course_id = $course_id AND
					f.field_group = '$document' AND 
					f.field_type = 'rating' AND
					f.is_active = 1
				ORDER BY f.field_order";

		return $this->wpdb->get_results( $sql, ARRAY_A ) ?? [];
	}


	// Get items checkbox type fields with grouped values for reporting
	public function get_items_report_checkbox( $course_id, $document ): array {
		$sql = "SELECT 
					f.field_label,
					f.field_options,
					f.field_order,
					d.field_value,
					COUNT(d.field_value) AS field_count
				FROM $this->table_fields  f
				INNER JOIN $this->table_item_detail d ON f.field_id_wpforms = d.field_id
				INNER JOIN $this->table_items i ON i.id = d.id_item
				WHERE 
					i.course_id = $course_id AND
					f.field_group = '$document' AND 
					f.field_type = 'checkbox' AND
					f.is_active = 1
				GROUP BY f.field_label, f.field_options, d.field_value, f.field_order
				ORDER BY f.field_order";
		
		return $this->wpdb->get_results( $sql, ARRAY_A ) ?? [];
	}


	// Get items comments type fields values for reporting
	public function get_items_report_comments( $course_id, $document ): array {
		$sql = "SELECT 
					f.field_label,
					f.field_order,
					d.field_value
				FROM $this->table_fields  f
				INNER JOIN $this->table_item_detail d ON f.field_id_wpforms = d.field_id
				INNER JOIN $this->table_items i ON i.id = d.id_item
				WHERE 
					i.course_id = $course_id AND
					f.field_group = '$document' AND 
					f.field_type = 'textarea' AND
					f.is_active = 1 AND
					d.field_value != ''
				ORDER BY f.field_order";

		return $this->wpdb->get_results( $sql, ARRAY_A ) ?? [];
	}

}