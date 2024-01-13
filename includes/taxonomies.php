<?php
/**
 * Taxonomies.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Taxonomies;

use function RosenfieldCollection\Theme\Helpers\column_class;

/**
 * Post tag
 * 
 * @var string
 */
const POST_TAG = 'post_tag';

/**
 * Firing
 * 
 * @var string
 */
const FIRING = 'rc_firing';

/**
 * Form
 * 
 * @var string
 */
const FORM = 'rc_form';

/**
 * Technique
 * 
 * @var string
 */
const TECHNIQUE = 'rc_technique';

/**
 * Row
 * 
 * @var string
 */
const ROW = 'rc_row';

/**
 * Column
 * 
 * @var string
 */
const COLUMN = 'rc_column';

/**
 * Location
 * 
 * @var string
 */
const LOCATION = 'rc_location';

/**
 * WordPress actions and filters
 */
function setup(): void {
	add_action( 'genesis_loop', __NAMESPACE__ . '\the_taxonomy_loop__firing' );
	add_action( 'genesis_loop', __NAMESPACE__ . '\the_taxonomy_loop__form' );
	add_action( 'genesis_loop', __NAMESPACE__ . '\the_taxonomy_loop__technique' );
}

/**
 * Taxonomy archive for Firing
 */
function the_taxonomy_loop__firing(): void {
	if ( ! is_page_template( 'templates/firings.php' ) ) {
		return;
	}

	get_template_part( 
		'partials/taxonomy-loop',
		null,
		[
			'taxonomy' => FIRING,
		] 
	);
}

/**
 * Taxonomy archive for Forms
 */
function the_taxonomy_loop__form(): void {
	if ( ! is_page_template( 'templates/forms.php' ) ) {
		return;
	}

	get_template_part( 
		'partials/taxonomy-loop',
		null,
		[
			'taxonomy' => FORM,
		] 
	);
}

/**
 * Taxonomy archive for Technique
 */
function the_taxonomy_loop__technique(): void {
	if ( ! is_page_template( 'templates/techniques.php' ) ) {
		return;
	}

	get_template_part( 
		'partials/taxonomy-loop',
		null,
		[
			'taxonomy' => TECHNIQUE,
		] 
	);
}
