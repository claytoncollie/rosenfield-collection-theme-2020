<?php
/**
 * Statistics
 * 
 * @package RosenfieldCollection\Theme
 */

$post_count  = wp_count_posts();
$post_count  = get_object_vars( $post_count );
$published   = (int) $post_count['publish'] ?? 0;
$users       = count_users();
$total_users = (int) $users['total_users'] ?? 0;

?>

<section class="statistics" aria-label="Site-wide statistics">
	<div class="one-half first">
		<h3>
			<?php echo esc_html( $published ); ?>
		</h3>
		<p>
			<?php echo esc_html__( 'Published Objects', 'rosenfield-collection' ); ?>
		</p>
	</div>
	<div class="one-half ">
		<h3>
			<?php echo esc_html( $total_users ); ?>
		</h3>
		<p>
			<?php echo esc_html__( 'Artists', 'rosenfield-collection' ); ?>
		</p>
	</div>
</section>