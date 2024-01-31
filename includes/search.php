<?php
/**
 * Search.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Search;

use WP_Post;
use WP_Query;

use function RosenfieldCollection\Theme\Helpers\get_object_prefix_and_id;
use function RosenfieldCollection\Theme\Helpers\svg;

use const RosenfieldCollection\Theme\Fields\ARTIST_PHOTO;
use const RosenfieldCollection\Theme\Fields\OBJECT_ID;
use const RosenfieldCollection\Theme\Fields\OBJECT_PREFIX;
use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;
use const RosenfieldCollection\Theme\Taxonomies\COLUMN;
use const RosenfieldCollection\Theme\Taxonomies\FIRING;
use const RosenfieldCollection\Theme\Taxonomies\FORM;
use const RosenfieldCollection\Theme\Taxonomies\LOCATION;
use const RosenfieldCollection\Theme\Taxonomies\POST_TAG;
use const RosenfieldCollection\Theme\Taxonomies\RESULT;
use const RosenfieldCollection\Theme\Taxonomies\ROW;
use const RosenfieldCollection\Theme\Taxonomies\TECHNIQUE;

/**
 * Setup
 */
function setup(): void {
	add_action( 'genesis_after_title_area', __NAMESPACE__ . '\do_header_search_form', 12 );
	add_filter( 'genesis_nav_items', __NAMESPACE__ . '\add_search_menu_item', 10, 2 );
	add_filter( 'wp_nav_menu_items', __NAMESPACE__ . '\add_search_menu_item', 10, 2 );
	add_filter( 'algolia_user_record', __NAMESPACE__ . '\avatar_url', 10, 2 );
	add_filter( 'algolia_post_images_sizes', __NAMESPACE__ . '\images_sizes' );
	add_filter( 'algolia_excluded_post_types', __NAMESPACE__ . '\post_types_blacklist' );
	add_filter( 'algolia_excluded_taxonomies', __NAMESPACE__ . '\taxonomies_blacklist' );
	add_filter( 'algolia_post_shared_attributes', __NAMESPACE__ . '\index_attributes', 10, 2 );
	add_filter( 'algolia_searchable_post_shared_attributes', __NAMESPACE__ . '\index_attributes', 10, 2 );
	add_filter( 'algolia_posts_index_settings', __NAMESPACE__ . '\index_settings' );
	add_filter( 'algolia_user_record', __NAMESPACE__ . '\user_attributes', 10, 2 );
	add_filter( 'algolia_users_index_settings', __NAMESPACE__ . '\user_settings' );
	add_filter( 'algolia_searchable_posts_index_settings', __NAMESPACE__ . '\index_settings' );
	add_filter( 'register_post_type_args', __NAMESPACE__ . '\exclude_from_search', 10, 2 );
}

/**
 * Outputs the header search form.
 */
function do_header_search_form(): void {
	$button = sprintf(
		'<a href="#" role="button" aria-expanded="false" aria-controls="header-search-wrap" class="toggle-header-search close"><span class="screen-reader-text">%s</span>%s</a>',
		__( 'Hide Search', 'rosenfield-collection' ),
		svg( 'times-solid' )
	);

	printf(
		'<div id="header-search-wrap" class="header-search-wrap">%s %s</div>',
		get_search_form( [ 'echo' => false ] ),
		$button // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}

/**
 * Modifies the menu item output of the header menu.
 *
 * @param string $items The menu HTML.
 * @param object $args The menu options.
 */
function add_search_menu_item( string $items, object $args ): string {
	$search_toggle = sprintf( '<li class="menu-item search-lg">%s</li>', get_header_search_toggle() );
	$search_mobile = sprintf(
		'<li class="menu-item search-m"><a href="%s">%s</a></li>',
		esc_url( add_query_arg( 's', '', get_bloginfo( 'url' ) ) ),
		esc_html__( 'Search', 'rosenfield-collection' )
	);

	if ( 'primary' === $args->theme_location ) { // @phpstan-ignore-line
		$items .= $search_toggle . $search_mobile;
	}

	return $items;
}

/**
 * Outputs the header search form toggle button.
 */
function get_header_search_toggle(): string {
	return sprintf(
		'<a href="#header-search-wrap" aria-controls="header-search-wrap" aria-expanded="false" role="button" class="toggle-header-search"><span class="screen-reader-text">%s</span>%s</a>',
		__( 'Show Search', 'rosenfield-collection' ),
		svg( 'search-solid' )
	);
}

/**
 * Replaces the default gravatar URL with their custom photo from the user profile.
 *
 * @param array  $record Record data.
 * @param object $item User meta.
 */
function avatar_url( array $record, object $item ): array {
	$avatar_id = get_field( ARTIST_PHOTO, 'user_' . $item->ID ); // @phpstan-ignore-line
	if ( ! empty( $avatar_id ) ) {
		$record['avatar_url'] = wp_get_attachment_url( (int) $avatar_id ); // @phpstan-ignore-line
	}

	return $record;
}

/**
 * Get all image sizes into the index.
 */
function images_sizes(): array {
	return get_intermediate_image_sizes(); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.get_intermediate_image_sizes_get_intermediate_image_sizes
}

/**
 * Remove certain post types from the index
 */
function post_types_blacklist(): array {
	return [
		'nav_menu_item',
		'amn_smtp',
		'oembed_cache',
		'customize_changeset',
		'custom_css',
		'user_request',
		'attachment',
		'revision',
		'wp_block',
		'acf-field',
		'acf-field-group',
		'shop_order',
		'shop_order_refund',
		'shop_coupon',
		'deprecated_log',
		'wp_stream_alerts',
		'scheduled-action',
		'wp_template',
	];
}

/**
 * Remove certain taxonomies from the index
 */
function taxonomies_blacklist(): array {
	return [
		'nav_menu',
		'link_category',
		'category',
		'post_format',
		ROW,
		LOCATION,
		COLUMN,
		TECHNIQUE,
		FORM,
		FIRING,
		POST_TAG,
		RESULT,
		'action-group',
		'wp_theme',
	];
}

/**
 * Define the additional attributes of Algolia.
 *
 * @param array   $attributes Default attributes.
 * @param WP_Post $post WP_Post object.
 */
function index_attributes( array $attributes, WP_Post $post ): array {
	$terms = get_the_terms( $post, FORM );
	if ( empty( $terms ) ) {
		return $attributes;
	}
	if ( is_wp_error( $terms ) ) {
		return $attributes;
	}

	$prefix = get_field( OBJECT_PREFIX, FORM . '_' . $terms[0]->term_id );
	if ( empty( $prefix ) ) {
		return $attributes;
	}

	$object_id = get_post_meta( $post->ID, OBJECT_ID, true );
	if ( empty( $object_id ) ) {
		return $attributes;
	}

	$attributes['rc_id'] = $prefix . $object_id;

	return $attributes;
}

/**
 * Define the sorting and filtering settings for Algolia.
 * 
 * @param array $settings Default settings.
 */
function index_settings( array $settings ): array {
	return array_merge(
		$settings,
		[
			'searchableAttributes'  => [ 
				'unordered(post_title)',
				'unordered(rc_id)',
				'unordered(post_author.display_name)',
				'unordered(taxonomies)',
			],
			'attributesForFaceting' => [ 
				'searchable(post_author.display_name)',
				'searchable(taxonomies)',
			],
		]
	);
}

/**
 * Define the additional attributes of Algolia.
 *
 * @param array $attributes Default attributes.
 * @param mixed $user User object.
 */
function user_attributes( array $attributes, mixed $user ): array {
	$author_id = $user->ID ?? 0; // @phpstan-ignore-line
	if ( empty( $author_id ) ) {
		return $attributes;
	}

	$posts = new WP_Query(
		[
			'post_type'      => POST_SLUG,
			'posts_per_page' => 100,
			'author'         => $author_id,
		]
	);
	if ( ! $posts->have_posts() ) {
		return $attributes;
	}

	while ( $posts->have_posts() ) {
		$posts->the_post();

		$attributes['rc_objects'] = [
			'id'    => get_object_prefix_and_id(),
			'title' => get_the_title(),
		];
	}
	wp_reset_postdata();

	return $attributes;
}

/**
 * Define the user settings for Algolia.
 */
function user_settings(): array {
	return [
		'searchableAttributes' => [
			'unordered(display_name)',
			'unordered(rc_objects)',
		],
		'customRanking'        => [
			'desc(posts_count)',
		],
	];
}

/**
 * Exclude certain post types from search results
 *
 * @param array  $args Arguments.
 * @param string $post_type Post type.
 */
function exclude_from_search( array $args, string $post_type ): array {
	if ( 'page' === $post_type ) {
		$args['exclude_from_search'] = true;
	}

	return $args;
}
