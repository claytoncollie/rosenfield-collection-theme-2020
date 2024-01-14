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

<div class="slider-gallery" role="navigation">
	<ul class="slider-gallery-images">
		<?php 
		foreach ( $images as $image ) : 
			$width     = (string) $image['sizes']['object-width'];
			$height    = (string) $image['sizes']['object-height'];
			$source    = (string) $image['sizes']['object'];
			$permalink = (string) $image['url'];
			$label     = (string) $image['title'];
			?>
			<li>
				<img 
					width="<?php echo esc_attr( $width ); ?>" 
					height="<?php echo esc_attr( $height ); ?>" 
					src="<?php echo esc_url( $source ); ?>" 
					alt="Made by <?php echo esc_attr( $full_name ); ?>"
				/>
				<a href="<?php echo esc_url( $permalink ); ?>" class="button" aria-label="Download full size image <?php echo esc_attr( $label ); ?>">
					<?php echo svg( 'cloud-download-alt-solid' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span class="label-download">
						<?php echo esc_html__( 'Download ', 'rosenfield-collection' ); ?>
					</span>
				</a>
			</li>
<?php endforeach; ?>
	</ul>
</div>
	