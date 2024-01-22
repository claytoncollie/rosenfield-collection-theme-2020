<?php
/**
 * Taxonomies.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Taxonomies;

use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;

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
 * Results
 * 
 * @var string
 */
const RESULT = 'rc_result';

/**
 * WordPress actions and filters
 */
function setup(): void {
	add_action( 'genesis_loop', __NAMESPACE__ . '\the_taxonomy_loop__firing' );
	add_action( 'genesis_loop', __NAMESPACE__ . '\the_taxonomy_loop__form' );
	add_action( 'genesis_loop', __NAMESPACE__ . '\the_taxonomy_loop__technique' );
	add_action( 'restrict_manage_posts', __NAMESPACE__ . '\filter_by_taxonomy' );
	add_action( 'admin_menu', __NAMESPACE__ . '\remove_sub_menus' );
	add_action( 'load-edit.php', __NAMESPACE__ . '\remove_category_filter' );
	add_action( 'init', __NAMESPACE__ . '\taxonomy_column' );
	add_action( 'init', __NAMESPACE__ . '\taxonomy_firing' );
	add_action( 'init', __NAMESPACE__ . '\taxonomy_form' );
	add_action( 'init', __NAMESPACE__ . '\taxonomy_location' );
	add_action( 'init', __NAMESPACE__ . '\taxonomy_row' );
	add_action( 'init', __NAMESPACE__ . '\taxonomy_technique' );
	add_action( 'init', __NAMESPACE__ . '\taxonomy_result' );
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


/**
 * Add drop down for custom taxonomies
 */
function filter_by_taxonomy(): void {
	global $typenow;

	$taxonomies = [
		FORM,
		FIRING,
		TECHNIQUE,
		COLUMN,
		ROW,
		LOCATION,
		RESULT,
	];

	if ( POST_SLUG !== $typenow ) {
		return;
	}

	foreach ( $taxonomies as $taxonomy ) {
		$tax_obj = get_taxonomy( $taxonomy );
		if ( empty( $tax_obj ) ) {
			continue;
		}

		$tax_name = $tax_obj->labels->name ?? '';
		if ( empty( $tax_name ) ) {
			continue;
		}

		$terms = get_terms( $taxonomy );
		if ( empty( $terms ) ) {
			continue;
		}

		$_GET[ $taxonomy ] = false;

		if ( count( $terms ) > 0 ) {
			printf(
				'<select name=%s id=%s class="postform">',
				esc_attr( $taxonomy ),
				esc_attr( $taxonomy )
			);

			printf(
				'<option value="">%s %s</option>',
				esc_html__( 'Show All', 'rosenfield-collection' ),
				esc_html( $tax_name )
			);

			foreach ( $terms as $term ) {
				printf(
					'<option value=%s %s>%s (%s)</option>',
					esc_attr( $term->slug ),
					$_GET[ $taxonomy ] === $term->slug ? ' selected="selected"' : '', // phpcs:ignore
					esc_html( $term->name ),
					(int) $term->count
				);
			}

			echo '</select>';
		}
	}
}

/**
 * Remove submenu pages for category and post tag
 */
function remove_sub_menus(): void {
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
}

/**
 * Remove category drop down on edit.php
 */
function remove_category_filter(): void {
	add_filter( 'wp_dropdown_cats', '__return_false' );
}

/**
 * Column
 */
function taxonomy_column(): void {
	$labels = [
		'name'                       => _x( 'Columns', 'Taxonomy General Name', 'rosenfield-collection' ),
		'singular_name'              => _x( 'Column', 'Taxonomy Singular Name', 'rosenfield-collection' ),
		'menu_name'                  => __( 'Columns', 'rosenfield-collection' ),
		'all_items'                  => __( 'All Items', 'rosenfield-collection' ),
		'parent_item'                => __( 'Parent Item', 'rosenfield-collection' ),
		'parent_item_colon'          => __( 'Parent Item:', 'rosenfield-collection' ),
		'new_item_name'              => __( 'New Item Name', 'rosenfield-collection' ),
		'add_new_item'               => __( 'Add New Item', 'rosenfield-collection' ),
		'edit_item'                  => __( 'Edit Item', 'rosenfield-collection' ),
		'update_item'                => __( 'Update Item', 'rosenfield-collection' ),
		'view_item'                  => __( 'View Item', 'rosenfield-collection' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'rosenfield-collection' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'rosenfield-collection' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'rosenfield-collection' ),
		'popular_items'              => __( 'Popular Items', 'rosenfield-collection' ),
		'search_items'               => __( 'Search Items', 'rosenfield-collection' ),
		'not_found'                  => __( 'Not Found', 'rosenfield-collection' ),
	];

	$rewrite = [
		'slug'         => 'column',
		'with_front'   => true,
		'hierarchical' => false,
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => false,
		'query_var'         => true,
		'rewrite'           => $rewrite,
		'meta_box_cb'       => false,
	];

	register_taxonomy( 
		COLUMN,
		POST_SLUG,
		$args 
	);
}

/**
 * Firing
 */
function taxonomy_firing(): void {
	$labels = [
		'name'                       => _x( 'Firings', 'Taxonomy General Name', 'rosenfield-collection' ),
		'singular_name'              => _x( 'Firing', 'Taxonomy Singular Name', 'rosenfield-collection' ),
		'menu_name'                  => __( 'Firings', 'rosenfield-collection' ),
		'all_items'                  => __( 'All Items', 'rosenfield-collection' ),
		'parent_item'                => __( 'Parent Item', 'rosenfield-collection' ),
		'parent_item_colon'          => __( 'Parent Item:', 'rosenfield-collection' ),
		'new_item_name'              => __( 'New Item Name', 'rosenfield-collection' ),
		'add_new_item'               => __( 'Add New Item', 'rosenfield-collection' ),
		'edit_item'                  => __( 'Edit Item', 'rosenfield-collection' ),
		'update_item'                => __( 'Update Item', 'rosenfield-collection' ),
		'view_item'                  => __( 'View Item', 'rosenfield-collection' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'rosenfield-collection' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'rosenfield-collection' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'rosenfield-collection' ),
		'popular_items'              => __( 'Popular Items', 'rosenfield-collection' ),
		'search_items'               => __( 'Search Items', 'rosenfield-collection' ),
		'not_found'                  => __( 'Not Found', 'rosenfield-collection' ),
	];

	$rewrite = [
		'slug'         => 'firing',
		'with_front'   => true,
		'hierarchical' => true,
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => false,
		'query_var'         => true,
		'rewrite'           => $rewrite,
		'meta_box_cb'       => false,
	];

	register_taxonomy( 
		FIRING,
		POST_SLUG,
		$args 
	);
}

/**
 * Form
 */
function taxonomy_form(): void {
	$labels = [
		'name'                       => _x( 'Forms', 'Taxonomy General Name', 'rosenfield-collection' ),
		'singular_name'              => _x( 'Form', 'Taxonomy Singular Name', 'rosenfield-collection' ),
		'menu_name'                  => __( 'Forms', 'rosenfield-collection' ),
		'all_items'                  => __( 'All Items', 'rosenfield-collection' ),
		'parent_item'                => __( 'Parent Item', 'rosenfield-collection' ),
		'parent_item_colon'          => __( 'Parent Item:', 'rosenfield-collection' ),
		'new_item_name'              => __( 'New Item Name', 'rosenfield-collection' ),
		'add_new_item'               => __( 'Add New Item', 'rosenfield-collection' ),
		'edit_item'                  => __( 'Edit Item', 'rosenfield-collection' ),
		'update_item'                => __( 'Update Item', 'rosenfield-collection' ),
		'view_item'                  => __( 'View Item', 'rosenfield-collection' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'rosenfield-collection' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'rosenfield-collection' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'rosenfield-collection' ),
		'popular_items'              => __( 'Popular Items', 'rosenfield-collection' ),
		'search_items'               => __( 'Search Items', 'rosenfield-collection' ),
		'not_found'                  => __( 'Not Found', 'rosenfield-collection' ),
	];

	$rewrite = [
		'slug'         => 'form',
		'with_front'   => true,
		'hierarchical' => false,
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => false,
		'query_var'         => true,
		'rewrite'           => $rewrite,
		'meta_box_cb'       => false,
	];

	register_taxonomy( 
		FORM,
		POST_SLUG,
		$args 
	);
}

/**
 * Location
 */
function taxonomy_location(): void {
	$labels = [
		'name'                       => _x( 'Locations', 'Taxonomy General Name', 'rosenfield-collection' ),
		'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'rosenfield-collection' ),
		'menu_name'                  => __( 'Locations', 'rosenfield-collection' ),
		'all_items'                  => __( 'All Items', 'rosenfield-collection' ),
		'parent_item'                => __( 'Parent Item', 'rosenfield-collection' ),
		'parent_item_colon'          => __( 'Parent Item:', 'rosenfield-collection' ),
		'new_item_name'              => __( 'New Item Name', 'rosenfield-collection' ),
		'add_new_item'               => __( 'Add New Item', 'rosenfield-collection' ),
		'edit_item'                  => __( 'Edit Item', 'rosenfield-collection' ),
		'update_item'                => __( 'Update Item', 'rosenfield-collection' ),
		'view_item'                  => __( 'View Item', 'rosenfield-collection' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'rosenfield-collection' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'rosenfield-collection' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'rosenfield-collection' ),
		'popular_items'              => __( 'Popular Items', 'rosenfield-collection' ),
		'search_items'               => __( 'Search Items', 'rosenfield-collection' ),
		'not_found'                  => __( 'Not Found', 'rosenfield-collection' ),
	];

	$rewrite = [
		'slug'         => 'location',
		'with_front'   => true,
		'hierarchical' => true,
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => false,
		'query_var'         => true,
		'rewrite'           => $rewrite,
		'meta_box_cb'       => false,
	];

	register_taxonomy(
		LOCATION,
		POST_SLUG,
		$args 
	);
}


/**
 * Row
 */
function taxonomy_row(): void {
	$labels = [
		'name'                       => _x( 'Rows', 'Taxonomy General Name', 'rosenfield-collection' ),
		'singular_name'              => _x( 'Row', 'Taxonomy Singular Name', 'rosenfield-collection' ),
		'menu_name'                  => __( 'Rows', 'rosenfield-collection' ),
		'all_items'                  => __( 'All Items', 'rosenfield-collection' ),
		'parent_item'                => __( 'Parent Item', 'rosenfield-collection' ),
		'parent_item_colon'          => __( 'Parent Item:', 'rosenfield-collection' ),
		'new_item_name'              => __( 'New Item Name', 'rosenfield-collection' ),
		'add_new_item'               => __( 'Add New Item', 'rosenfield-collection' ),
		'edit_item'                  => __( 'Edit Item', 'rosenfield-collection' ),
		'update_item'                => __( 'Update Item', 'rosenfield-collection' ),
		'view_item'                  => __( 'View Item', 'rosenfield-collection' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'rosenfield-collection' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'rosenfield-collection' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'rosenfield-collection' ),
		'popular_items'              => __( 'Popular Items', 'rosenfield-collection' ),
		'search_items'               => __( 'Search Items', 'rosenfield-collection' ),
		'not_found'                  => __( 'Not Found', 'rosenfield-collection' ),
	];

	$rewrite = [
		'slug'         => 'row',
		'with_front'   => true,
		'hierarchical' => false,
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => false,
		'query_var'         => true,
		'rewrite'           => $rewrite,
		'meta_box_cb'       => false,
	];

	register_taxonomy( 
		ROW,
		POST_SLUG,
		$args 
	);
}

/**
 * Technique
 */
function taxonomy_technique(): void {
	$labels = [
		'name'                       => _x( 'Techniques', 'Taxonomy General Name', 'rosenfield-collection' ),
		'singular_name'              => _x( 'Technique', 'Taxonomy Singular Name', 'rosenfield-collection' ),
		'menu_name'                  => __( 'Techniques', 'rosenfield-collection' ),
		'all_items'                  => __( 'All Items', 'rosenfield-collection' ),
		'parent_item'                => __( 'Parent Item', 'rosenfield-collection' ),
		'parent_item_colon'          => __( 'Parent Item:', 'rosenfield-collection' ),
		'new_item_name'              => __( 'New Item Name', 'rosenfield-collection' ),
		'add_new_item'               => __( 'Add New Item', 'rosenfield-collection' ),
		'edit_item'                  => __( 'Edit Item', 'rosenfield-collection' ),
		'update_item'                => __( 'Update Item', 'rosenfield-collection' ),
		'view_item'                  => __( 'View Item', 'rosenfield-collection' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'rosenfield-collection' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'rosenfield-collection' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'rosenfield-collection' ),
		'popular_items'              => __( 'Popular Items', 'rosenfield-collection' ),
		'search_items'               => __( 'Search Items', 'rosenfield-collection' ),
		'not_found'                  => __( 'Not Found', 'rosenfield-collection' ),
	];

	$rewrite = [
		'slug'         => 'technique',
		'with_front'   => true,
		'hierarchical' => false,
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => false,
		'query_var'         => true,
		'rewrite'           => $rewrite,
		'meta_box_cb'       => false,
	];

	register_taxonomy( 
		TECHNIQUE,
		POST_SLUG,
		$args 
	);
}

/**
 * Result
 */
function taxonomy_result(): void {
	$labels = [
		'name'                       => _x( 'Results', 'Taxonomy General Name', 'rosenfield-collection' ),
		'singular_name'              => _x( 'Result', 'Taxonomy Singular Name', 'rosenfield-collection' ),
		'menu_name'                  => __( 'Results', 'rosenfield-collection' ),
		'all_items'                  => __( 'All Items', 'rosenfield-collection' ),
		'parent_item'                => __( 'Parent Item', 'rosenfield-collection' ),
		'parent_item_colon'          => __( 'Parent Item:', 'rosenfield-collection' ),
		'new_item_name'              => __( 'New Item Name', 'rosenfield-collection' ),
		'add_new_item'               => __( 'Add New Item', 'rosenfield-collection' ),
		'edit_item'                  => __( 'Edit Item', 'rosenfield-collection' ),
		'update_item'                => __( 'Update Item', 'rosenfield-collection' ),
		'view_item'                  => __( 'View Item', 'rosenfield-collection' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'rosenfield-collection' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'rosenfield-collection' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'rosenfield-collection' ),
		'popular_items'              => __( 'Popular Items', 'rosenfield-collection' ),
		'search_items'               => __( 'Search Items', 'rosenfield-collection' ),
		'not_found'                  => __( 'Not Found', 'rosenfield-collection' ),
	];

	$rewrite = [
		'slug'         => 'result',
		'with_front'   => true,
		'hierarchical' => false,
	];

	$args = [
		'labels'            => $labels,
		'hierarchical'      => false,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud'     => false,
		'query_var'         => true,
		'rewrite'           => $rewrite,
		'meta_box_cb'       => false,
	];

	register_taxonomy( 
		RESULT,
		POST_SLUG,
		$args 
	);
}
