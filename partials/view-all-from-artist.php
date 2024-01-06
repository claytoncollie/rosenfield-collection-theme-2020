<?php
/**
 * View all objects by artist
 * 
 * @package RosenfieldCollection\Theme
 */

use const RosenfieldCollection\Theme\ImageSizes\THUMBNAIL;

$author_id = get_the_author_meta( 'ID' );
if ( empty( $author_id ) ) {
	return;
}

$avatar_id = get_field( 'artist_photo', 'user_' . $author_id );
$avatar_id = $avatar_id ? (int) $avatar_id : 0;
if ( empty( $avatar_id ) ) {
	return;
}

$first_name = get_the_author_meta( 'first_name' );
$last_name  = get_the_author_meta( 'last_name' );
$full_name  = $first_name . ' ' . $last_name;
$permalink  = get_author_posts_url( $author_id );
$avatar     = wp_get_attachment_image(
	$avatar_id,
	THUMBNAIL,
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
		<?php echo esc_html__( 'View more objects by ', 'rosenfield-collection' ); ?>
		<?php echo esc_html( $full_name ); ?>
	</a>
</p>