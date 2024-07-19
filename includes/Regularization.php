<?php

namespace dcms\lms_forms\includes;

use dcms\lms_forms\helpers\FieldGroup;
use dcms\lms_forms\helpers\Rating;

class Regularization {

	public function __construct() {
		add_action( 'template_redirect', [ $this, 'process_regularization' ] );
	}

	public function process_regularization(): void {
		if ( ! isset( $_GET['regularization'] ) ) {
			return;
		}

		$this->regularize_totals();
	}
	
	private function regularize_totals(): void {
		// Get all items to regularize
		$db    = new Database();
		$items = $db->get_all_items();

		foreach ( $items as $item ) {
			$item_id      = $item['id'];
			$documents    = FieldGroup::get_groups();
			$documents_db = FieldGroup::get_groups_db_names();

			foreach ( $documents as $document ) {
				$sum    = 0;
				$values = $db->get_item_ratings( $item_id, $document );

				foreach ( $values as $value ) {
					$sum += Rating::RATING_VALUES[ $value['field_value'] ];
				}

				// Update item
				$return = $db->update_item_document_value( $item_id, $documents_db[ $document ], $sum );
				error_log( print_r( $return, true ) );
			}
		}
	}
}
