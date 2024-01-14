<?php
/**
 * List view post meta
 * 
 * @package RosenfieldCollection\Theme
 */

use const RosenfieldCollection\Theme\Fields\OBJECT_PRICE;
use const RosenfieldCollection\Theme\Taxonomies\COLUMN;
use const RosenfieldCollection\Theme\Taxonomies\FIRING;
use const RosenfieldCollection\Theme\Taxonomies\FORM;
use const RosenfieldCollection\Theme\Taxonomies\LOCATION;
use const RosenfieldCollection\Theme\Taxonomies\ROW;
use const RosenfieldCollection\Theme\Taxonomies\TECHNIQUE;

$post_id = get_the_ID();
$post_id = $post_id ? (int) $post_id : 0;
if ( empty( $post_id ) ) {
	return;
}

$forms = get_the_term_list( $post_id, FORM, '', ', ', '' );
$forms = $forms && ! is_wp_error( $forms ) ? (string) $forms : '';

$firings = get_the_term_list( $post_id, FIRING, '', ', ' );
$firings = $firings && ! is_wp_error( $firings ) ? (string) $firings : '';

$techniques = get_the_term_list( $post_id, TECHNIQUE, '', ', ' );
$techniques = $techniques && ! is_wp_error( $techniques ) ? (string) $techniques : '';

$rows = get_the_term_list( $post_id, ROW, '', ', ' );
$rows = $rows && ! is_wp_error( $rows ) ? (string) $rows : '';

$columns = get_the_term_list( $post_id, COLUMN, '', ', ' );
$columns = $columns && ! is_wp_error( $columns ) ? (string) $columns : '';

$location = get_the_term_list( $post_id, LOCATION, '', ', ' );
$location = $location && ! is_wp_error( $location ) ? (string) $location : '';

$price = get_field( OBJECT_PRICE, $post_id );
$price = $price ? (string) $price : ''; // @phpstan-ignore-line

$is_user_logged_in = is_user_logged_in();

?>

<div class="taxonomies">
	<?php if ( ! empty( $forms ) ) : ?>
		<span class="entry-sep">&middot;</span>
		<?php echo wp_kses_post( $forms ); ?>
	<?php endif; ?>

	<?php if ( ! empty( $firings ) ) : ?>
		<span class="entry-sep">&middot;</span>
		<?php echo wp_kses_post( $firings ); ?>
	<?php endif; ?>

	<?php if ( ! empty( $techniques ) ) : ?>
		<span class="entry-sep">&middot;</span>
		<?php echo wp_kses_post( $techniques ); ?>
	<?php endif; ?>
</div>

<?php if ( $is_user_logged_in ) : ?>
	<div class="location">
		<?php if ( ! empty( $columns ) ) : ?>
			<?php echo esc_html__( 'Column', 'rosenfield-collection' ); ?><?php echo wp_kses_post( $columns ); ?>
		<?php endif; ?>

		<?php if ( ! empty( $rows ) ) : ?>
			<span class="entry-sep">&middot;</span><?php echo esc_html__( 'Row ', 'rosenfield-collection' ); ?><?php echo wp_kses_post( $rows ); ?>
		<?php endif; ?>

		<?php if ( ! empty( $location ) ) : ?>
			<span class="entry-sep">&middot;</span><?php echo wp_kses_post( $location ); ?>
		<?php endif; ?>

		<?php if ( ! empty( $price ) ) : ?>
			<span class="entry-sep">&middot;</span>$<?php echo wp_kses_post( $price ); ?>
		<?php endif; ?>
	</div>
<?php endif; ?>