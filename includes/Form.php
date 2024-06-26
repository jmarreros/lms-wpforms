<?php

namespace dcms\lms_forms\includes;

use dcms\lms_forms\helpers\FieldGroup;
use dcms\lms_forms\helpers\FieldType;

class Form {

	private int $form_id;

	public function __construct() {
		$this->form_id = get_option( DCMS_WPFORMS_FORM_ID, 0 );

		add_filter( 'wpforms_field_properties_hidden', [ $this, 'fill_hidden_fields' ], 10, 3 );
		add_action( 'wpforms_frontend_output_before', [ $this, 'form_was_filled' ], 10, 2 );

		add_action( 'wpforms_process_complete', [ $this, 'save_front_end_form_data' ], 10, 4 );
		add_action( 'wpforms_pro_admin_entries_edit_process', [ $this, 'edit_admin_form_data_from_entries' ], 10, 3 );
	}



	// Fill hidden fields wpforms with custom values, only necessary fill course_id and course_name
	// Other fields are filled by WPForm configuration hidden field
	public function fill_hidden_fields( $properties, $field, $form_data ): array {

		// Validate only for front-end
		if ( is_admin() ) {
			return $properties;
		}

		if ( absint( $form_data['id'] ) === $this->form_id ) {

			$value = $properties['inputs']['primary']['attr']['value'];

			$db = new Database();
			switch ( $field['label'] ) {
				case 'course_id':
					$data  = $db->get_course_data_by_lesson( get_the_ID() );
					$value = $data['course_id'];
					break;
				case 'course_name':
					$data  = $db->get_course_data_by_lesson( get_the_ID() );
					$value = $data['course_name'];
					break;
			}

			$properties['inputs']['primary']['attr']['value'] = $value;
		}

		return $properties;
	}

	// Add custom styles to show or hide form and next button at the top of the form
	public function form_was_filled( $form_data, $form ): void {

		if ( absint( $form_data['id'] ) !== $this->form_id ) {
			return;
		}

		$db          = new Database();
		$lesson_data = $db->get_course_data_by_lesson( get_the_ID() );
		$course_id   = $lesson_data['course_id'];

		$item_data = $db->get_item_data( get_current_user_id(), $course_id );

		if ( empty( $item_data ) ) { // User does not have item data, does not fill the form
			echo "<style>.masterstudy-course-player-navigation__next{display:none!important;}</style>";
		} else {
			echo "<h3>Ya has completado la encuesta</h3>";
			echo "<style>.wpforms-container{display:none;}</style>";
		}

	}

	public function get_wpforms_fields( $id_wpforms ): array {
		$db      = new Database();
		$content = $db->get_wpforms_content( $id_wpforms );
		$types   = [ FieldType::Rating, FieldType::Textarea, FieldType::Checkbox ];

		$data = json_decode( $content );

		if ( empty( $data ) ) {
			return [];
		}

		$fields = [];
		foreach ( $data->fields as $field ) {
			if ( in_array( $field->type, $types ) ) {
				$field_options = '';
				if ( $field->type === FieldType::Checkbox ) {
					foreach ( $field->choices as $choice ) {
						$field_options .= $choice->label . '|';
					}
				}
				$fields[ $field->id ] = [
					'field_label'   => $field->label,
					'field_type'    => $field->type,
					'field_options' => rtrim( $field_options, '|' )
				];
			}
		}

		return $fields;
	}

	// Get merged fields from wpforms and database configuration
	public function get_fields_configuration(): array {
		$db = new Database();

		$fields_db      = $db->get_fields();
		$fields_wpforms = $this->get_wpforms_fields( $this->form_id );

		$fields = [];

		// Fill database configuration info
		foreach ( $fields_db as $field_db ) {
			$fields[ $field_db['field_id_wpforms'] ] = [
				'field_label'   => $field_db['field_label'],
				'field_type'    => $field_db['field_type'],
				'field_options' => $field_db['field_options'],
				'field_group'   => $field_db['field_group'],
				'field_order'   => $field_db['field_order']
			];
		}

		// Fill wpforms fields
		foreach ( $fields_wpforms as $key => $field_wpforms ) {
			if ( array_key_exists( $key, $fields ) ) {
				$fields[ $key ]['field_label'] = $field_wpforms['field_label'];
				continue;
			}

			$fields[ $key ] = [
				'field_label'   => $field_wpforms['field_label'],
				'field_type'    => $field_wpforms['field_type'],
				'field_options' => $field_wpforms['field_options'],
				'field_group'   => '',
				'field_order'   => 0
			];
		}

		return $fields;
	}


	// Save form data
	public function save_front_end_form_data( $fields, $entry, $form_data, $entry_id ): void {

		if ( absint( $form_data['id'] ) !== $this->form_id || is_admin() ) {
			return;
		}

		$db = new Database();

		// Get only value from first element of the filter array
		$course_id   = array_values( filter_from_fields( 'course_id', $fields ) )[0]['value'] ?? 0;
		$course_data = $db->get_course_data( $course_id );

		// Item data
		$item = [
			'user_id'          => get_current_user_id(),
			'course_id'        => $course_id,
			'author_id'        => $course_data['author_id'],
			'entry_id_wpforms' => $entry_id,
			'total_foac04'     => 0,
			'total_foac05'     => 0,
			'total_foac06'     => 0,
		];

		$fields_db = $db->get_fields();

		$item_details = [];
		foreach ( $fields_db as $field_db ) {

			$id = $field_db['field_id_wpforms'];
			if ( ! array_key_exists( $field_db['field_id_wpforms'], $fields ) ) {
				continue;
			}

			// Detail item data
			$item_details[] = [
				'field_id'    => $id,
				'field_value' => $fields[ $id ] ['value'] ?? '',
			];

			// sum rating fields totals items for each group
			if ( $field_db['field_type'] === FieldType::Rating ) {
				switch ( $field_db['field_group'] ) {
					case FieldGroup::FO_AC_04:
						$item['total_foac04'] += intval( $fields[ $id ] ['value'] );
						break;
					case FieldGroup::FO_AC_05:
						$item['total_foac05'] += intval( $fields[ $id ] ['value'] );
						break;
					case FieldGroup::FO_AC_06:
						$item['total_foac06'] += intval( $fields[ $id ] ['value'] );
						break;
				}
			}
		}

		$db->save_items_fields( $item, $item_details );
	}

	// Edit data entries from admin interface
	public function edit_admin_form_data_from_entries($fields, $entry, $form_data):void{
//		error_log(print_r('Aquí wpforms_pro_admin_entries_edit_process',true));
//		error_log(print_r(is_admin(),true));
//		error_log(print_r($entry,true));
	}
}

//[id] => 115886
//    [entry_id] => 14607
//    [fields] => Array
//(
//	[2] => 4
//            [19] => 4
//            [13] => Array
//(
//	[0] => Si
//)
//
//[27] => llt
//        )
