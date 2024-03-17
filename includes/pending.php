<?php
/**
 * Pending.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Pending;

use WP_Post;

use const RosenfieldCollection\Theme\Fields\CLAIM_SLUG;
use const RosenfieldCollection\Theme\Fields\PENDING_SLUG;
use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;
use const RosenfieldCollection\Theme\QueryVars\ARTIST_VAR;
use const RosenfieldCollection\Theme\QueryVars\POST_ID_VAR;
use const RosenfieldCollection\Theme\Taxonomies\FORM;

/**
 * Setup
 */
function setup(): void {
	add_action( 'genesis_loop', __NAMESPACE__ . '\the_loop' );
	add_filter( 'post_link', __NAMESPACE__ . '\get_the_permalink_with_post_id', 10, 2 );
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\filters', 25 );
	add_action( 'genesis_entry_content', __NAMESPACE__ . '\purchase_meta' );
}

/**
 * Display all posts labeled PENDING
 */
function the_loop(): void {
	if ( ! is_page_template( 'templates/pending.php' ) ) {
		return;
	}

	$args = [
		'post_type'   => POST_SLUG,
		'post_status' => PENDING_SLUG,
		'paged'       => get_query_var( 'paged' ),
		'order'       => 'ASC',
		'orderby'     => 'author',
	];

	$user = get_query_var( ARTIST_VAR );
	if ( ! empty( $user ) ) {
		$args['author'] = absint( $user );
	}

	$form = get_query_var( FORM );
	if ( ! empty( $form ) ) {
		$args['tax_query'] = [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			[
				'taxonomy' => FORM,
				'field'    => 'slug',
				'terms'    => $form,
			],
		];
	}

	genesis_custom_loop( $args );
}

/**
 * Filter the permalink on the PENDING page to include a query argument with the post ID.
 *
 * @param string  $url Permalink.
 * @param WP_Post $post Post Object.
 */
function get_the_permalink_with_post_id( string $url, WP_Post $post ): string {
	if ( is_admin() ) {
		return $url;
	}

	if ( POST_SLUG !== get_post_type( $post->ID ) ) {
		return $url;
	}

	if ( PENDING_SLUG !== get_post_status( $post->ID ) ) {
		return $url;
	}

	return add_query_arg( 
		POST_ID_VAR,
		$post->ID,
		home_url( CLAIM_SLUG ) 
	);
}

/**
 * Search and filter
 */
function filters(): void {
	if ( ! is_page_template( 'templates/pending.php' ) ) {
		return;
	}
	?>

	<div class="row">
		<?php get_template_part( 'partials/pending-filter-by-form' ); ?>
		<?php get_template_part( 'partials/pending-filter-by-artist' ); ?>
	</div>

	<?php
}

/**
 * Purchase meta data
 */
function purchase_meta(): void {
	get_template_part( 'partials/purchase-meta' );
}
