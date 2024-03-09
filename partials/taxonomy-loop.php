<?php
/**
 * Taxonomy Loop
 * 
 * @package RosenfieldCollection\Theme
 */

use const RosenfieldCollection\Theme\Fields\TERM_THUMBNAIL;
use const RosenfieldCollection\Theme\ImageSizes\IMAGE_ARCHIVE;

$taxonomy = $args['taxonomy'] ?? '';
if ( empty( $taxonomy ) ) {
	return;
}

$terms = get_terms( 
	[
		'taxonomy'   => $taxonomy,
		'parent'     => 0,
		'hide_empty' => 1,
	]
);

if ( empty( $terms ) ) {
	return;
}
if ( is_wp_error( $terms ) ) {
	return;
}

?>

<?php 
foreach ( $terms as $term ) :
	$term_id    = $term->term_id;
	$term_slug  = $term->slug;
	$term_name  = $term->name;
	$term_count = $term->count;
	$term_link  = get_term_link( $term );
	$term_link  = ! empty( $term_link ) && ! is_wp_error( $term_link ) ? (string) $term_link : '';
	$image_id   = get_term_meta( $term_id, TERM_THUMBNAIL, true );
	$image_id   = $image_id ? (int) $image_id : 0; // @phpstan-ignore-line
	$image      = wp_get_attachment_image(
		$image_id,
		IMAGE_ARCHIVE,
		false,
		[
			'class' => 'img-fluid border shadow-sm',
			'alt'   => sprintf(
				'%s %s',
				esc_html__( 'Newest object from category:', 'rosenfield-collection' ),
				esc_html( $term_name )
			),
		]
	);
	?>

	<article class="col col-12 col-md-3" aria-label="Category: <?php echo esc_attr( $term_name ); ?>">
		<?php if ( ! empty( $image ) && ! empty( $image_id ) ) : ?>	
			<a href="<?php echo esc_url( $term_link ); ?>" class="d-block">
				<?php echo wp_kses_post( $image ); ?>
			</a>
		<?php endif; ?>
		<div class="d-inline-block p-2 text-center w-100">
			<h2 class="h4">
				<a href="<?php echo esc_url( $term_link ); ?>" class="link-dark link-hidden-dots">
					<?php echo esc_html( $term_name ); ?>
				</a>
			</h2>
			<a class="link-fancy" href="<?php echo esc_url( $term_link ); ?>" aria-label="View Category: <?php echo esc_attr( $term_name ); ?>">
				<?php echo esc_html__( 'View All', 'rosenfield-collection' ); ?>
			</a>
			<span class="entry-sep">
				&middot;
			</span>
			<?php echo esc_html( (string) $term_count ); ?>
		</div>
	</article>
<?php endforeach; ?>
