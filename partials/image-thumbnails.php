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

<ul class="slider-thumbnails-images list-unstyled d-flex flex-row flex-md-column">
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
		<li class="d-block position-relative w-100 text-left me-2 me-md-0 mb-2">
			<img 
				class="img-fluid mw-65 mw-md-150 shadow-sm border border-1"
				width="<?php echo esc_attr( $width ); ?>" 
				height="<?php echo esc_attr( $height ); ?>" 
				src="<?php echo esc_url( $source ); ?>" 
				alt="Thumbnail of <?php echo esc_attr( $title ); ?>"
			/>
		</li>
	<?php endforeach; ?>
</ul>