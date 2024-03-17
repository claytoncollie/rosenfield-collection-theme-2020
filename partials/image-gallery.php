<?php
/**
 * Image Gallery
 * 
 * @package RosenfieldCollection\Theme
 */

use function RosenfieldCollection\Theme\Helpers\svg;

$images = $args['images'] ?? [];

if ( empty( $images ) ) {
	return;
}

$first_name = get_the_author_meta( 'first_name' );
$last_name  = get_the_author_meta( 'last_name' );
$full_name  = $first_name . ' ' . $last_name;

?>

<ul class="slider-gallery-images list-unstyled">
	<?php 
	foreach ( $images as $image ) : 
		$width     = (string) $image['sizes']['object-width'];
		$height    = (string) $image['sizes']['object-height'];
		$source    = (string) $image['sizes']['object'];
		$permalink = (string) $image['url'];
		$label     = (string) $image['title'];
		?>
		<li class="position-relative">
			<img 
				class="img-fluid border shadow-sm"
				width="<?php echo esc_attr( $width ); ?>" 
				height="<?php echo esc_attr( $height ); ?>" 
				src="<?php echo esc_url( $source ); ?>" 
				alt="Made by <?php echo esc_attr( $full_name ); ?>"
			/>
			<a href="<?php echo esc_url( $permalink ); ?>" class=" d-md-flex align-items-center d-print-none position-absolute bottom-0 py-1 py-md-2 px-2 px-md-3 bg-dark text-light text-decoration-none" aria-label="Download full size image <?php echo esc_attr( $label ); ?>">
				<?php echo svg( 'cloud-download-alt-solid' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span class="d-none d-md-inline-block ps-2 link-light">
					<?php echo esc_html__( 'Download ', 'rosenfield-collection' ); ?>
				</span>
			</a>
		</li>
<?php endforeach; ?>
</ul>
	