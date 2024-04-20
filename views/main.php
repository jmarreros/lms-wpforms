<?php
$current_item = $_GET['item'] ?? '';
$current_document = $_GET['document'] ?? '';

if ( ! $current_item ) {
	include_once DCMS_WPFORMS_PATH . '/views/report.php';
} else {
	include_once DCMS_WPFORMS_PATH . '/views/report-detail.php';
}