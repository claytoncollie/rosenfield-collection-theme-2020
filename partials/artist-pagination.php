<?php
/**
 * Artist Pagination
 * 
 * @package RosenfieldCollection\Theme
 */

use const RosenfieldCollection\Theme\Artists\QUERY_VAR;
use const RosenfieldCollection\Theme\Artists\POSTS_PER_PAGE;
use const RosenfieldCollection\Theme\Artists\MAX_PER_PAGE;
use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;

// Get the query var to know if we are filtering or not.
$filter_value = get_query_var( QUERY_VAR ) ?? [];
// Set high value to disable pagination when using query var.
$posts_per_page = empty( $filter_value ) ? POSTS_PER_PAGE : MAX_PER_PAGE;
// Set up pagination.
$is_paged    = get_query_var( 'paged' );
$page_number = $is_paged ? $is_paged : 1;
$offset      = ( $page_number - 1 ) * $posts_per_page;
// Setup the possible meta query.
$filter_query = [];
if ( ! empty( $filter_value ) ) {
	$filter_query = [
		'meta_key'     => QUERY_VAR,
		'meta_value'   => $filter_value, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
		'meta_compare' => '=',
	];
}
// Run the query.
$user_query = new WP_User_Query(
	array_merge_recursive(
		[
			'order'               => 'ASC',
			'orderby'             => 'display_name',
			'has_published_posts' => [ POST_SLUG ],
			'number'              => $posts_per_page,
			'offset'              => $offset,
		],
		$filter_query
	)
);

if ( empty( $user_query->results ) ) {
	return;
}

if ( ! empty( $filter_value ) ) {
	$total_users = count( $user_query->results );
} else {
	$total_users = count( get_users( [ 'has_published_posts' => [ POST_SLUG ] ] ) );
}

$total_pages = (int) ( $total_users / $posts_per_page ) + 1;

if ( $total_users < $posts_per_page ) {
	return;
}

?>

<section id="genesis-archive-pagination" class="pagination container-xxl py-5" role="navigation" aria-label="Pagination">
	<?php 
	echo wp_kses_post(
		paginate_links( // @phpstan-ignore-line
			[
				'base'      => get_pagenum_link( 1 ) . '%_%',
				'format'    => 'page/%#%/',
				'current'   => (int) max( 1, $is_paged ), // @phpstan-ignore-line
				'total'     => $total_pages,
				'prev_next' => true,
				'type'      => 'list',
			]
		)
	); 
	?>
</section>
