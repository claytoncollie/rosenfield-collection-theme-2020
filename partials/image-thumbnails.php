<?php
/**
 * Image Thumbnails
 * 
 * @package RosenfieldCollection\Theme
 */

$images = $args['images'] ?? [];

if ( empty( $images ) ) {
	return;
}

?>

<section class="slider-thumbnails" aria-label="Thumbnail Images">
	<ul class="slider-thumbnails-images">
		<?php 
		foreach ( $images as $image ) : 
			$width = $image['sizes']['thumbnail-width'] ?? false;
			$width = $width ? (string) $width : '';

			$height = $image['sizes']['thumbnail-height'] ?? false;
			$height = $height ? (string) $height : '';

			$source = $image['sizes']['thumbnail'] ?? false;
			$source = $source ? (string) $source : '';

			$title = $image['title'] ?? false;
			$title = $title ? (string) $title : '';
			?>
			<li>
				<img 
					width="<?php echo esc_attr( $width ); ?>" 
					height="<?php echo esc_attr( $height ); ?>" 
					src="<?php echo esc_url( $source ); ?>" 
					alt="Thumbnail of <?php echo esc_attr( $title ); ?>"
				/>
			</li>
		<?php endforeach; ?>
	</ul>
</section>