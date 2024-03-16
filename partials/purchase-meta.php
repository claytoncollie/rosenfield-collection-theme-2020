<?php
/**
 * Purchase meta
 * 
 * @package RosenfieldCollection\Theme
 */

use const RosenfieldCollection\Theme\Fields\OBJECT_DATE;
use const RosenfieldCollection\Theme\Fields\OBJECT_PRICE;
use const RosenfieldCollection\Theme\Fields\PENDING_SLUG;
use const RosenfieldCollection\Theme\Taxonomies\LOCATION;

$post_id = get_the_ID();
$post_id = $post_id ? (int) $post_id : 0;
if ( empty( $post_id ) ) {
	return;
}

$post_status = get_post_status( $post_id );
$post_status = $post_status ? (string) $post_status : '';
if ( PENDING_SLUG !== $post_status ) {
	return;
}

$location = get_the_term_list( $post_id, LOCATION, '', ', ', '' );
$location = $location && ! is_wp_error( $location ) ? $location : '';

$price = get_field( OBJECT_PRICE );
$price = $price ? (string) $price : ''; // @phpstan-ignore-line

$date = get_field( OBJECT_DATE );
$date = $date ? (string) $date : ''; // @phpstan-ignore-line

?>

<?php if ( ! empty( $price ) ) : ?>
	<hr>
	<div class="text-start">
		<?php echo esc_html__( 'Price', 'rosenfield-collection' ); ?>:
		<strong>
			<?php echo esc_html( $price ); ?>
		</strong>
	</div>
	<hr>
<?php endif; ?>

<?php if ( ! empty( $date ) ) : ?>
	<div class="text-start">
		<?php echo esc_html__( 'Date', 'rosenfield-collection' ); ?>:
		<strong>
			<?php echo esc_html( $date ); ?>
		</strong>
	</div>
	<hr>
<?php endif; ?>

<?php if ( ! empty( $location ) ) : ?>
	<div class="text-start">
		<?php echo esc_html__( 'Location', 'rosenfield-collection' ); ?>:
		<strong>
			<?php echo wp_kses_post( $location ); ?>
		</strong>
	</div> 
<?php endif; ?>
