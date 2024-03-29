<?php
/**
 * Author name and object ID below the post title
 * 
 * @package RosenfieldCollection\Theme
 */

use function RosenfieldCollection\Theme\Helpers\get_object_prefix_and_id;
use function RosenfieldCollection\Theme\Helpers\is_list_view;

$author_id = (int) get_the_author_meta( 'ID' );
if ( empty( $author_id ) ) {
	return;
}

$first_name = get_the_author_meta( 'first_name', $author_id );
$last_name  = get_the_author_meta( 'last_name', $author_id );
$full_name  = $first_name . ' ' . $last_name;
$permalink  = get_author_posts_url( $author_id );
$object_id  = get_object_prefix_and_id();
$link_style = is_list_view() ? '' : 'link-fancy';

?>

<a href="<?php echo esc_url( $permalink ); ?>" class="<?php echo esc_attr( $link_style ); ?>">
	<?php echo esc_html( $full_name ); ?>
</a>

<?php if ( ! empty( $object_id ) ) : ?>
	<span class="entry-sep">
		&middot;
	</span>
	<?php echo esc_html( $object_id ); ?>
<?php endif; ?>