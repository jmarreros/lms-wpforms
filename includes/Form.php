<?php

namespace dcms\lms_forms\includes;

use dcms\lms_forms\helpers\FieldType;

class Form {

	private int $form_id;

	public function __construct() {
		$this->form_id = get_option( DCMS_WPFORMS_FORM_ID, 0 );

		add_filter( 'wpforms_field_properties_hidden', [ $this, 'fill_hidden_fields' ], 10, 3 );
		add_action( 'wpforms_frontend_output_before', [ $this, 'form_was_filled' ], 10, 2 );
	}

	// Fill hidden fields wpforms with custom values
	public function fill_hidden_fields( $properties, $field, $form_data ): array {
		if ( absint( $form_data['id'] ) === $this->form_id ) {

			$value = $properties['inputs']['primary']['attr']['value'];

			$db = new Database();
			switch ( $field['label'] ) {
				case 'user_id':
					$value = get_current_user_id();
					break;
				case 'course_id':
					$data  = $db->get_lesson_data( get_the_ID() );
					$value = $data['course_id'];
					break;
				case 'author_id':
					$data  = $db->get_lesson_data( get_the_ID() );
					$value = $data['author_id'];
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
		$lesson_data = $db->get_lesson_data( get_the_ID() );
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
					'field_label'      => $field->label,
					'field_type'       => $field->type,
					'field_options'    => $field_options
				];
			}
		}

		return $fields;
	}

	// Get merged fields from wpforms and database configuration
	public function get_fields_configuration(): array {
		$db = new Database();

		$fields_db = $db->get_fields();
		$fields_wpforms       = $this->get_wpforms_fields( $this->form_id );

		$fields = [];

		// Fill database configuration info
		foreach ( $fields_db as $field_db ) {
			$fields[ $field_db['field_id_wpforms'] ] = [
				'field_label'   => $field_db['field_label'],
				'field_type'    => $field_db['field_type'],
				'field_options' => $field_db['field_options'],
				'field_group'   => $field_db['field_group']
			];
		}

		// Fill wpforms fields
		foreach ( $fields_wpforms as $key => $field_wpforms ) {
			if ( array_key_exists( $key, $fields ) ) {
				continue;
			}

			$fields[ $key ] = [
				'field_label'   => $field_wpforms['field_label'],
				'field_type'    => $field_wpforms['field_type'],
				'field_options' => $field_wpforms['field_options'],
				'field_group'   => ''
			];
		}

		return $fields;
	}
}