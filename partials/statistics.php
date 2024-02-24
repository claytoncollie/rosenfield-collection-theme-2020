<?php
/**
 * Statistics
 * 
 * @package RosenfieldCollection\Theme
 */

$post_count  = wp_count_posts();
$post_count  = get_object_vars( $post_count );
$published   = (string) $post_count['publish']; // @phpstan-ignore-line
$users       = count_users();
$total_users = (string) $users['total_users'];

?>

<div class="row py-5">
	<div class="col col-6">
		<h3>
			<?php echo esc_html( $published ); ?>
		</h3>
		<p>
			<?php echo esc_html__( 'Published Objects', 'rosenfield-collection' ); ?>
		</p>
	</div>
	<div class="col col-6">
		<h3>
			<?php echo esc_html( $total_users ); ?>
		</h3>
		<p>
			<?php echo esc_html__( 'Artists', 'rosenfield-collection' ); ?>
		</p>
	</div>
</div>