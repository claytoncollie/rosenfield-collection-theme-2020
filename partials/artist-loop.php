<?php
/**
 * Artist Loop
 * 
 * @package RosenfieldCollection\Theme
 */

use const RosenfieldCollection\Theme\Artists\QUERY_VAR;
use const RosenfieldCollection\Theme\Artists\POSTS_PER_PAGE;
use const RosenfieldCollection\Theme\Artists\MAX_PER_PAGE;
use const RosenfieldCollection\Theme\Fields\ARTIST_PHOTO;
use const RosenfieldCollection\Theme\ImageSizes\IMAGE_THUMBNAIL;
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

$users = $user_query->results ?? [];
if ( empty( $users ) ) {
	return;
}

foreach ( $users as $user ) :
	$fallback        = '';
	$user_id         = (int) $user->ID;
	$first_name      = (string) $user->first_name;
	$last_name       = (string) $user->last_name;
	$full_name       = $first_name . ' ' . $last_name;
	$permalink       = get_author_posts_url( $user_id );
	$number_of_posts = count_user_posts( $user_id );
	$attachment_id   = get_field( ARTIST_PHOTO, 'user_' . $user_id );
	$attachment_id   = $attachment_id ? (int) $attachment_id : 0; // @phpstan-ignore-line
	$avatar          = wp_get_attachment_image_src( $attachment_id, IMAGE_THUMBNAIL );
	$avatar          = is_array( $avatar ) ? $avatar : [];
	$avatar_width    = $avatar[1] ?? false;
	$avatar_width    = $avatar_width ? (string) $avatar_width : '';
	$avatar_height   = $avatar[2] ?? false;
	$avatar_height   = $avatar_height ? (string) $avatar_height : '';
	$avatar_src      = $avatar[0] ?? '';
	$avatar_src      = '' !== $avatar_src && '0' !== $avatar_src ? (string) $avatar_src : '';

	/**
	* If the artist/user does not have a photo in the custom field
	* then get_posts for that author an grab the featured image from
	* the first post and use as fallback image.
	*/
	if ( 0 === $attachment_id ) {
		$author_posts = get_posts( 
			[
				'author'         => $user_id,
				'posts_per_page' => 1, 
			]
		);
		
		if ( ! empty( $author_posts ) ) {
			foreach ( $author_posts as $author_post ) {
				$fallback = get_the_post_thumbnail(
					(int) $author_post->ID, // @phpstan-ignore-line
					IMAGE_THUMBNAIL,
					[
						'alt'   => esc_attr( $full_name ),
						'class' => 'img-fluid border shadow-sm',
					]
				);
			}
		}
	}
	?>

	<article class="col col-6 col-md-4 col-lg-3 col-xl-2 text-center" aria-label="Artist: <?php echo esc_attr( $full_name ); ?>">
		<?php if ( 0 !== $attachment_id ) : ?>
			<a href="<?php echo esc_url( $permalink ); ?>" class="d-block">
				<img
					class="img-fluid border shadow-sm"
					width="<?php echo esc_attr( $avatar_width ); ?>" 
					height="<?php echo esc_attr( $avatar_height ); ?>" 
					src="<?php echo esc_url( $avatar_src ); ?>" 
					alt="<?php echo esc_attr( $full_name ); ?>" 
				/>
			</a>
		<?php else : ?>
			<a href="<?php echo esc_url( $permalink ); ?>" class="d-block">
				<?php echo wp_kses_post( $fallback ); ?>
			</a>
		<?php endif; ?>
		<div class="d-inline-block p-2 w-100">
			<h2 class="h5">
				<a href="<?php echo esc_url( $permalink ); ?>" class="link-dark link-hidden-dots">
					<?php echo esc_html( $full_name ); ?>
				</a>
			</h2>
			<a class="link-fancy" href="<?php echo esc_url( $permalink ); ?>"  aria-label="View artist: <?php echo esc_attr( $full_name ); ?>">
				<?php echo esc_html__( 'View Artist', 'rosenfield-collection' ); ?>
			</a>
			<span class="entry-sep">
				&middot;
			</span>
			<?php echo esc_html( $number_of_posts ); ?>
		</div>
	</article>
<?php endforeach; ?>
