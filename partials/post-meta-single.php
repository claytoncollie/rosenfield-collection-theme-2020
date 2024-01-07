<?php
/**
 * Post meta for single template
 * 
 * @package RosenfieldCollection\Theme
 */

use const RosenfieldCollection\Theme\Taxonomies\COLUMN;
use const RosenfieldCollection\Theme\Taxonomies\FIRING;
use const RosenfieldCollection\Theme\Taxonomies\FORM;
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

$length = get_field( 'length', $post_id );
$length = $length ? (string) $length : '';
$width  = get_field( 'width', $post_id );
$width  = $width ? (string) $width : '';
$height = get_field( 'height', $post_id );
$height = $height ? (string) $height : '';

$author_id        = (int) get_the_author_meta( 'ID' );
$author_permalink = get_author_posts_url( $author_id );
$first_name       = get_the_author_meta( 'first_name', $author_id );
$last_name        = get_the_author_meta( 'last_name', $author_id );
$full_name        = $first_name . ' ' . $last_name;

// Load all 'rc_form' terms for the post.
$terms     = get_the_terms( $post_id, FORM );
$terms     = $terms && ! is_wp_error( $terms ) ? $terms : [];
$object_id = get_field( 'object_id', $post_id );
$term      = array_pop( $terms );
$prefix    = get_field( 'rc_form_object_prefix', $term );

?>

<section id="rosenfield-collection-object-data" class="post-meta" role="contentinfo" aria-label="Object data">
	<div class="wrap">
		<div class="data">

			<?php if ( ! empty( $prefix ) && ! empty( $object_id ) ) : ?>
				<span>
					<?php echo esc_html( $prefix ); ?>
					<?php echo esc_html( $object_id ); ?>
				</span>
			<?php endif; ?>

			<span class="entry-sep">
				&middot;
			</span>
			<span>
				<a href="<?php echo esc_url( $author_permalink ); ?>" rel="author">
					<?php echo esc_html( $full_name ); ?>
				</a>
			</span>

			<?php if ( ! empty( $forms ) ) : ?>
				<span class="entry-sep">
					&middot;
				</span>
				<?php echo wp_kses_post( $forms ); ?>
			<?php endif; ?>
			
			<?php if ( ! empty( $firings ) ) : ?>
				<span class="entry-sep">
					&middot;
				</span>
				<?php echo wp_kses_post( $firings ); ?>
			<?php endif; ?>
			
			<?php if ( ! empty( $techniques ) ) : ?>
				<span class="entry-sep">
					&middot;
				</span>
				<?php echo wp_kses_post( $techniques ); ?>
			<?php endif; ?>
			
			<?php if ( $length || $width || $height ) : ?>
				<span class="entry-sep">
					&middot;
				</span>
				<?php echo esc_html( $length ); ?> x 
				<?php echo esc_html( $width ); ?> x 
				<?php echo esc_html( $height ); ?>
				&nbsp;
				<?php echo esc_html__( 'inches', 'rosenfield-collection' ); ?>
			<?php endif; ?>

		</div>
		
		<div class="location">

			<?php if ( ! empty( $columns ) ) : ?>
				<?php echo esc_html__( 'Column', 'rosenfield-collection' ); ?>
				&nbsp;
				<?php echo wp_kses_post( $columns ); ?>
			<?php endif; ?>

			<?php if ( ! empty( $rows ) ) : ?>
				<span class="entry-sep">
					&middot;
				</span>
				<?php echo esc_html__( 'Row', 'rosenfield-collection' ); ?>
				&nbsp;
				<?php echo wp_kses_post( $rows ); ?>
			<?php endif; ?>

		</div>
	</div>
</section>