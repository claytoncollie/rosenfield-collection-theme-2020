<?php
/**
 * Gravity Forms Styles.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\GravityFormsStyles;

const FORM_CONTROL_EXCLUDE = [
	'hidden',
	'password',
	'fileupload',
	'list',
	'html',
	'post_image',
	'post_category',
	'product',
	'option',
];

/**
 * Setup actions and filters
 */
function setup(): void {
	if ( ! class_exists( 'GFCommon' ) ) {
		return;
	}

	add_filter( 'pre_option_rg_gforms_disable_css', '__return_true' );
	add_filter( 'pre_option_rg_gforms_enable_html5', '__return_true' );
	add_filter( 'gform_field_content', __NAMESPACE__ . '\autocomplete_attribute', 10, 2 );
	add_filter( 'gform_field_content', __NAMESPACE__ . '\bootstrap_classes', 10, 2 );
	add_filter( 'gform_validation_message', __NAMESPACE__ . '\validation_message' );
	add_filter( 'gform_submit_button', __NAMESPACE__ . '\submit_button' );
	add_filter( 'gform_next_button', __NAMESPACE__ . '\next_button' );
	add_filter( 'gform_previous_button', __NAMESPACE__ . '\previous_button' );
	add_filter( 'gform_savecontinue_link', __NAMESPACE__ . '\save_continue_button' );
	add_filter( 'gform_progress_bar', __NAMESPACE__ . '\progress_bar' );
	add_filter( 'gform_ajax_spinner_url', __NAMESPACE__ . '\hide_spinner' );
}

/**
 * Add autocomplete to the email field.
 */
function autocomplete_attribute( string $field_content, object $field ): string {
	$field_type = $field->type ?? '';

	if ( 'email' === $field_type ) {
		return str_replace( 'type=', "autocomplete='email' type=", $field_content );
	}

	return $field_content;
}

/**
 * Add classes to all fields.
 *
 * @param string       $content Markup.
 * @param object|array $field Data.
 */
function bootstrap_classes( string $content, $field ): string {
	$field_type     = $field['type'] ?? '';
	$input_type     = $field['inputType'] ?? '';
	$multiple_files = $field['multipleFiles'] ?? '';

	// Add .form-control to most inputs except those listed.
	if ( ! in_array( $field_type, FORM_CONTROL_EXCLUDE, true ) ) {
		$content = str_replace( "class='small", "class='form-control form-control-sm", $content );
		$content = str_replace( "class='medium", "class='form-control", $content );
		$content = str_replace( "class='large", "class='form-control form-control-lg", $content );
	}

	// Labels.
	$content = str_replace( 'gfield_label', 'form-label gfield_label', $content );

	// Descriptions.
	$content = str_replace( "class='gfield_description", "class='small text-muted gfield_description", $content );

	// Validation message.
	$content = str_replace( "class='small text-muted gfield_description validation_message", "class='alert alert-warning p-1 small gfield_description validation_message", $content );

	// Sections.
	$content = str_replace( "class='gsection_description", "class='gsection_description small text-muted", $content );

	// Number fields.
	$content = str_replace( 'ginput_quantity ', 'form-control ginput_quantity ', $content );
	$content = str_replace( 'ginput_amount ', 'form-control ginput_amount ', $content );

	// Select fields.
	$content = str_replace( 'gfield_select', 'form-select', $content );
	if ( 'select' === $field_type || 'post_category' === $field_type ) {
		$content = str_replace( "class='small form-select", "class='form-select form-select-sm", $content );
		$content = str_replace( "class='medium form-select", "class='form-select", $content );
		$content = str_replace( "class='large form-select", "class='form-select form-select-lg", $content );
	}

	// Textarea fields.
	if ( 'textarea' === $field_type || 'post_content' === $field_type || 'post_excerpt' === $field_type ) {
		$content = str_replace( "class='textarea small", "class='form-control form-control-sm textarea", $content );
		$content = str_replace( "class='textarea medium", "class='form-control textarea", $content );
		$content = str_replace( "class='textarea large", "class='form-control form-control-lg textarea", $content );
		$content = str_replace( "rows='10'", "rows='4'", $content );
	}

	// Checkbox fields.
	if ( 'checkbox' === $field_type || 'checkbox' === $input_type ) {
		$content = str_replace( 'gchoice ', 'form-check gchoice ', $content );
		$content = str_replace( "<input class='gfield-choice-input", "<input class='form-check-input gfield-choice-input", $content );
		$content = str_replace( '<label for', "<label class='form-check-label' for", $content );
		$content = str_replace( 'type="button"', 'type="button" class="btn btn-primary btn-sm"', $content ); // 'Other' option.
	}

	// Radio fields.
	if ( 'radio' === $field_type || 'radio' === $input_type ) {
		$content = str_replace( 'gchoice ', 'gchoice form-check ', $content );
		$content = str_replace( "<input class='gfield-choice-input", "<input class='form-check-input gfield-choice-input'", $content );
		$content = str_replace( "<label class='form-radio-label", "<label class='form-check-label form-radio-label", $content );
		$content = str_replace( "type='text'", "type='text' class='form-control form-control-sm'", $content ); // 'Other' option.
	}

	// Post Image meta data fields.
	if ( 'post_image' === $field_type ) {
		$content = str_replace( "type='text'", "type='text' class='form-control form-control-sm'", $content );
	}

	// Date fields.
	if ( 'date' === $field_type ) {
		$content = str_replace( '<select', "<select class='form-select'", $content );
		$content = str_replace( 'ginput_complex', 'row g-2 ginput_complex', $content );
		$content = str_replace( 'ginput_container_date', 'col ginput_container_date', $content );
		$content = str_replace( "type='number'", "type='number' class='form-control'", $content );
		$content = str_replace( 'label for=', 'label class="small text-muted" for=', $content );
		$content = str_replace( "class='datepicker", "class='form-control datepicker", $content );
	}

	// Date & Time fields.
	if ( 'time' === $field_type ) {
		$content = str_replace( '<select', "<select class='form-select'", $content );
		$content = str_replace( 'ginput_complex', 'row g-2 ginput_complex', $content );
		$content = str_replace( 'ginput_container_time', 'col ginput_container_time', $content );
		$content = str_replace( 'hour_minute_colon', 'd-none hour_minute_colon', $content );
		$content = str_replace( "type='number'", "type='number' class='form-control'", $content );
		$content = str_replace( "label class='hour_label", "label class='small text-muted hour_label", $content );
		$content = str_replace( "label class='minute_label", "label class='small text-muted minute_label", $content );
	}

	// Complex fields.
	if ( 'name' === $field_type || 'address' === $field_type || 'email' === $field_type || 'password' === $field_type ) {
		$content = str_replace( "class='ginput_complex", "class='row g-2 ginput_complex", $content );
		$content = str_replace( "class='ginput_left", "class='col-12 col-md-6 ginput_left", $content );
		$content = str_replace( "class='ginput_right", "class='col-12 col-md-6 ginput_right", $content );
		$content = str_replace( "class='ginput_full", "class='col-12 col-md-12 ginput_full", $content );
	}

	// Password fields.
	if ( 'password' === $field_type ) {
		$content = str_replace( "type='password'", "type='password' class='form-control' ", $content );
		$content = str_replace( '<label for', "<label class='small muted' for", $content );
	}

	// Email fields.
	if ( 'email' === $field_type ) {
		$content = str_replace( "small'   placeholder", "form-control form-control-sm'   placeholder", $content );
		$content = str_replace( "medium'   placeholder", "form-control'   placeholder", $content );
		$content = str_replace( "large'   placeholder", "form-control form-control-lg'   placeholder", $content );
		$content = str_replace( "<input class=''", "<input class='form-control'", $content );
		$content = str_replace( '<label for', "<label class='small muted' for", $content );
	}

	// Name & Address fields.
	if ( 'name' === $field_type || 'address' === $field_type ) {
		$content = str_replace( "class='name_", "class='col-12 col-md name_", $content );
		$content = str_replace( "type='text'", "type='text' class='form-control'", $content );
		$content = str_replace( '<select ', "<select class='form-select' ", $content );
		$content = str_replace( 'label for=', "label class='small text-muted' for=", $content );
	}

	// Consent fields.
	if ( 'consent' === $field_type ) {
		$content = str_replace( 'ginput_container_consent', 'form-check ginput_container_consent', $content );
		$content = str_replace( 'gfield_consent_label', 'form-check-label gfield_consent_label', $content );
		$content = str_replace( "type='checkbox'", "type='checkbox' class='form-check-input' ", $content );
	}

	// List fields.
	if ( 'list' === $field_type ) {
		$content = str_replace( "type='text'", "type='text' class='form-control'", $content );
		$content = str_replace( "gfield_list_header'", "row gfield_list_header'", $content );
		$content = str_replace( 'gfield_list_header', 'row gfield_list_header', $content );
		$content = str_replace( 'gfield_header_item"', 'col gfield_header_item"', $content );
		$content = str_replace( 'gfield_header_item--icons"', 'col-1 gfield_header_item--icons"', $content );
		$content = str_replace( " gfield_list_group'", " row g-3 gfield_list_group'", $content );
		$content = str_replace( 'gfield_list_group_item', 'col mb-2 gfield_list_group_item', $content );
		$content = str_replace( 'gfield_list_icons', 'col-1 gfield_list_icons', $content );
	}

	// Fileupload fields. Add class 'preview' to the field to enable the image preview.
	if ( 'fileupload' === $field_type || 'post_image' === $field_type ) {
		// Single file uploads.
		$content = str_replace( "type='file' class='medium'", "type='file' class='form-control'", $content );
		$content = str_replace( 'gform_fileupload_rules', 'small text-muted gform_fileupload_rules', $content );
		$content = str_replace( 'validation_message', 'text-danger small list-unstyled validation_message', $content );
		$content = str_replace( "id='extensions_message", "class='small text-muted' id='extensions_message", $content );
		$content = str_replace( 'label for=', "label class='small text-muted' for=", $content );

		// Multi file upload.
		if ( true === $multiple_files ) {
			$content = str_replace( "class='button", "class='btn btn-primary btn-sm", $content );
		}
	}

	return $content;
}

/**
 * Added classes to validation message.
 */
function validation_message(): string {
	return "<div class='validation_error'>" . esc_html__( 'There was a problem with your submission.', 'rosenfield-collection' ) . ' ' . esc_html__( 'Errors have been highlighted below.', 'rosenfield-collection' ) . '</div>';
}

/**
 * Add classes to the submit button.
 */
function submit_button( string $button ): string {
	return str_replace( "class='gform_button", "class='gform_button btn btn-primary", $button );
}

/**
 * Add classes to next button.
 */
function next_button( string $button ): string {
	return str_replace( "class='gform_next_button", "class='gform_next_button btn btn-secondary", $button );
}

/**
 * Add classes to previous button.
 */
function previous_button( string $button ): string {
	return str_replace( "class='gform_previous_button", "class='gform_previous_button btn btn-outline-secondary", $button );
}

/**
 * Add classes to save and continue button.
 */
function save_continue_button( string $button ): string {
	return str_replace( "class='gform_save_link", "class='btn btn-outline-secondary gform_save_link", $button );
}

/**
 * Add classes to the progress bar.
 */
function progress_bar( string $progress_bar ): string {
	$progress_bar = str_replace( 'gf_progressbar ', 'progress gf_progressbar ', $progress_bar );
	$progress_bar = str_replace( 'gf_progressbar_percentage', 'progress-bar progress-bar-striped progress-bar-animated progress_percentage', $progress_bar );
	$progress_bar = str_replace( 'percentbar_blue', 'bg-primary percentbar_blue', $progress_bar );
	$progress_bar = str_replace( 'percentbar_gray', 'bg-secondary percentbar_gray', $progress_bar );
	$progress_bar = str_replace( 'percentbar_green', 'bg-success percentbar_green', $progress_bar );
	$progress_bar = str_replace( 'percentbar_orange', 'bg-warning percentbar_orange', $progress_bar );

	return str_replace( 'percentbar_red', 'bg-danger percentbar_red', $progress_bar );
}

/**
 * Hide the default spinner icon.
 */
function hide_spinner(): string {
	return 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
}
