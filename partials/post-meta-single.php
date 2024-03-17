<?php
/**
 * Post meta for single template
 * 
 * @package RosenfieldCollection\Theme
 */

use function RosenfieldCollection\Theme\Helpers\get_the_terms_light_links;

use const RosenfieldCollection\Theme\Fields\OBJECT_HEIGHT;
use const RosenfieldCollection\Theme\Fields\OBJECT_ID;
use const RosenfieldCollection\Theme\Fields\OBJECT_LENGTH;
use const RosenfieldCollection\Theme\Fields\OBJECT_PREFIX;
use const RosenfieldCollection\Theme\Fields\OBJECT_WIDTH;
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

$forms = get_the_terms_light_links( $post_id, FORM );
$forms = empty( $forms ) ? '' : $forms;

$firings = get_the_terms_light_links( $post_id, FIRING );
$firings = empty( $firings ) ? '' : $firings;

$techniques = get_the_terms_light_links( $post_id, TECHNIQUE );
$techniques = empty( $techniques ) ? '' : $techniques;

$rows = get_the_terms_light_links( $post_id, ROW );
$rows = empty( $rows ) ? '' : $rows;

$columns = get_the_terms_light_links( $post_id, COLUMN );
$columns = empty( $columns ) ? '' : $columns;

$length = get_field( OBJECT_LENGTH, $post_id );
$length = $length ? (string) $length : ''; // @phpstan-ignore-line
$width  = get_field( OBJECT_WIDTH, $post_id );
$width  = $width ? (string) $width : ''; // @phpstan-ignore-line
$height = get_field( OBJECT_HEIGHT, $post_id );
$height = $height ? (string) $height : ''; // @phpstan-ignore-line

$author_id        = get_post_field( 'post_author', $post_id );
$author_id        = empty( $author_id ) ? 0 : (int) $author_id;
$author_permalink = get_author_posts_url( $author_id );
$first_name       = get_the_author_meta( 'first_name', $author_id );
$last_name        = get_the_author_meta( 'last_name', $author_id );
$full_name        = $first_name . ' ' . $last_name;

// Load all 'rc_form' terms for the post.
$terms     = get_the_terms( $post_id, FORM );
$terms     = $terms && ! is_wp_error( $terms ) ? $terms : [];
$object_id = get_field( OBJECT_ID, $post_id );
$object_id = $object_id ? (string) $object_id : ''; // @phpstan-ignore-line
$term      = array_pop( $terms );
$prefix    = get_field( OBJECT_PREFIX, $term );
$prefix    = $prefix ? (string) $prefix : ''; // @phpstan-ignore-line

?>

<section id="rosenfield-collection-object-data" class="sticky-md-top container-xxl bg-dark text-light border-1 border-dotted-top border-secondary py-2" role="contentinfo" aria-label="Object data">
	<div class="row">
		<div class="col col-12 col-md-9">
			<?php if ( ! empty( $prefix ) && ! empty( $object_id ) ) : ?>
				<span>
					<?php echo esc_html( $prefix ); ?>
					<?php echo esc_html( $object_id ); ?>
				</span>
			<?php endif; ?>

			<span class="entry-sep text-white">
				&middot;
			</span>
			<span>
				<a href="<?php echo esc_url( $author_permalink ); ?>" class="link-light link-hidden-dots-light">
					<?php echo esc_html( $full_name ); ?>
				</a>
			</span>

			<?php if ( ! empty( $forms ) ) : ?>
				<span class="entry-sep text-white">
					&middot;
				</span>
				<?php echo wp_kses_post( $forms ); ?>
			<?php endif; ?>

			<?php if ( ! empty( $firings ) ) : ?>
				<span class="entry-sep text-white">
					&middot;
				</span>
				<?php echo wp_kses_post( $firings ); ?>
			<?php endif; ?>

			<?php if ( ! empty( $techniques ) ) : ?>
				<span class="entry-sep text-white">
					&middot;
				</span>
				<?php echo wp_kses_post( $techniques ); ?>
			<?php endif; ?>

			<?php if ( $length || $width || $height ) : ?>
				<span class="entry-sep text-white">
					&middot;
				</span>
				<?php echo esc_html( $length ); ?> x 
				<?php echo esc_html( $width ); ?> x 
				<?php echo esc_html( $height ); ?>
				&nbsp;
				<?php echo esc_html__( 'inches', 'rosenfield-collection' ); ?>
			<?php endif; ?>

		</div>

		<div class="col col-12 col-md-3 d-flex justify-content-md-end">

			<?php if ( ! empty( $columns ) ) : ?>
				<?php echo esc_html__( 'Column', 'rosenfield-collection' ); ?>
				&nbsp;
				<?php echo wp_kses_post( $columns ); ?>
			<?php endif; ?>

			<?php if ( ! empty( $rows ) ) : ?>
				<span class="entry-sep text-white">
					&middot;
				</span>
				<?php echo esc_html__( 'Row', 'rosenfield-collection' ); ?>
				&nbsp;
				<?php echo wp_kses_post( $rows ); ?>
			<?php endif; ?>

		</div>
	</div>
</section>