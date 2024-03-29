<?php

namespace dcms\wpforms\includes;

class Form {

	public function __construct() {
		add_filter( 'wpforms_field_properties_hidden', [ $this, 'fill_hidden_fields' ], 10, 3 );
	}

	// Fill hidden fields wpforms with custom values
	public function fill_hidden_fields( $properties, $field, $form_data ): array {
		if ( absint( $form_data['id'] ) === 115883 ) {

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
}