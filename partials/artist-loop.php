<?php
/**
 * Artist Loop
 * 
 * @package RosenfieldCollection\Theme
 */

use function RosenfieldCollection\Theme\Helpers\column_class;

use const RosenfieldCollection\Theme\Artists\QUERY_VAR;
use const RosenfieldCollection\Theme\Artists\POSTS_PER_PAGE;

// Keep count for columns.
$index = 0;
// Get the query var to know if we are filtering or not.
$filter_value = get_query_var( QUERY_VAR ) ?? [];
// Set high value to disable pagination when using query var.
$posts_per_page = ! empty( $filter_value ) ? 999 : POSTS_PER_PAGE;
// Set up pagination.
$page_number = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
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
			'has_published_posts' => [ 'post' ],
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
	$total_users = (int) count( $user_query->results );
} else {
	$total_users = (int) count( get_users( [ 'has_published_posts' => [ 'post' ] ] ) );
}

$total_pages = intval( $total_users / $posts_per_page ) + 1;

foreach ( $user_query->results as $user ) :
	$fallback        = '';
	$user_id         = $user->ID;
	$first_name      = $user->first_name;
	$last_name       = $user->last_name;
	$full_name       = $first_name . ' ' . $last_name;
	$column_class    = column_class( $index, 6 );
	$permalink       = get_author_posts_url( $user_id );
	$number_of_posts = count_user_posts( $user_id );
	$attachment_id   = get_field( 'artist_photo', 'user_' . $user_id );
	$avatar          = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
	$avatar          = is_array( $avatar ) ? $avatar : [];
	$avatar_width    = $avatar[1] ?? false;
	$avatar_width    = $avatar_width ? (string) $avatar_width : '';
	$avatar_height   = $avatar[2] ?? false;
	$avatar_height   = $avatar_height ? (string) $avatar_height : '';
	$avatar_src      = $avatar[0] ?? '';
	$avatar_src      = $avatar_src ? (string) $avatar_src : '';

	/**
	* If the artist/user does not have a photo in the custom field
	* then get_posts for that author an grab the featured image from
	* the first post and use as fallback image.
	*/
	if ( ! $attachment_id ) {
		$author_posts = get_posts( 'author=' . esc_attr( $user_id ) . '&posts_per_page=1' );
		foreach ( $author_posts as $author_post ) {
			$fallback = get_the_post_thumbnail(
				(int) $author_post->ID,
				'thumbnail',
				[
					'alt' => esc_html( $full_name ),
				]
			);
		}
	}
	?>

	<article class="entry one-sixth <?php echo esc_attr( $column_class ); ?>" aria-label="Artist: <?php echo esc_attr( $full_name ); ?>">
		<?php if ( $attachment_id ) : ?>
			<a href="<?php echo esc_url( $permalink ); ?>" class="entry-image-link" rel="bookmark">
				<img 
					width="<?php echo esc_attr( $avatar_width ); ?>" 
					height="<?php echo esc_attr( $avatar_height ); ?>" 
					src="<?php echo esc_url( $avatar_src ); ?>" 
					alt="<?php echo esc_attr( $full_name ); ?>" 
				/>
			</a>
		<?php else : ?>
			<a href="<?php echo esc_url( $permalink ); ?>" class="entry-image-link" rel="bookmark">
				<?php echo wp_kses_post( $fallback ); ?>
			</a>
		<?php endif; ?>
		<div class="entry-wrap">
			<header class="entry-header">
				<h2 class="entry-title" itemprop="name">
					<a href="<?php echo esc_url( $permalink ); ?>" rel="bookmark">
						<?php echo esc_html( $full_name ); ?>
					</a>
				</h2>
				<a class="more-link" href="<?php echo esc_url( $permalink ); ?>" rel="bookmark" aria-label="View artist: <?php echo esc_attr( $full_name ); ?>">
					<?php echo esc_html__( 'View Artist', 'rosenfield-collection' ); ?>
				</a>
				<span class="entry-sep">
					&middot;
				</span>
				<?php echo esc_html( $number_of_posts ); ?>
			</header>
		</div>
	</article>
	<?php ++$index; ?>
<?php endforeach; ?>

<?php if ( $total_users > $posts_per_page ) : ?>
	<section id="genesis-archive-pagination" class="archive-pagination pagination" role="navigation" aria-label="Pagination">
		<div class="wrap">
			<?php 
			echo wp_kses_post(
				paginate_links(
					[
						'base'      => get_pagenum_link( 1 ) . '%_%',
						'format'    => 'page/%#%/',
						'current'   => max( 1, get_query_var( 'paged' ) ),
						'total'     => $total_pages,
						'prev_next' => true,
						'type'      => 'list',
					]
				)
			); 
			?>
		</div>
	</section>
<?php endif; ?>
