<?php
/**
 * View all objects by artist
 * 
 * @package RosenfieldCollection\Theme
 */

use const RosenfieldCollection\Theme\Fields\ARTIST_PHOTO;
use const RosenfieldCollection\Theme\ImageSizes\IMAGE_THUMBNAIL;

$post_id = get_the_ID();
$post_id = $post_id ? (int) $post_id : 0;
if ( empty( $post_id ) ) {
	return;
}

$author_id = (int) get_post_field( 'post_author', $post_id );
if ( empty( $author_id ) ) {
	return;
}

$first_name = get_the_author_meta( 'first_name', $author_id );
$last_name  = get_the_author_meta( 'last_name', $author_id );
$full_name  = $first_name . ' ' . $last_name;
$permalink  = get_author_posts_url( $author_id );
$avatar_id  = get_field( ARTIST_PHOTO, 'user_' . $author_id );
$avatar_id  = $avatar_id ? (int) $avatar_id : 0; // @phpstan-ignore-line
$avatar     = wp_get_attachment_image(
	$avatar_id,
	IMAGE_THUMBNAIL,
	false,
	[
		'class' => 'author-avatar',
		'alt'   => esc_attr( $full_name ),
	]
);

?>

<p class="author-view-more">
	<?php echo wp_kses_post( $avatar ); ?>
	<a class="more-link" rel="author" href="<?php echo esc_url( $permalink ); ?>">
		<?php echo esc_html__( 'View more objects by', 'rosenfield-collection' ); ?>
		<?php echo esc_html( $full_name ); ?>
	</a>
</p>