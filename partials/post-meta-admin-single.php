<?php
/**
 * Post meta admin only for single template
 * 
 * @package RosenfieldCollection\Theme
 */

use function RosenfieldCollection\Theme\Helpers\get_the_terms_light_links;

use const RosenfieldCollection\Theme\Fields\OBJECT_DATE;
use const RosenfieldCollection\Theme\Fields\OBJECT_PRICE;
use const RosenfieldCollection\Theme\Taxonomies\LOCATION;
use const RosenfieldCollection\Theme\Taxonomies\POST_TAG;

if ( ! is_user_logged_in() ) {
	return;
}

$post_id = get_the_ID();
$post_id = $post_id ? (int) $post_id : 0;
if ( empty( $post_id ) ) {
	return;
}

$tags             = get_the_terms_light_links( $post_id, POST_TAG );
$tags             = empty( $tags ) ? '' : $tags;
$location         = get_the_terms_light_links( $post_id, LOCATION );
$location         = empty( $location ) ? '' : $location;
$price            = get_post_meta( $post_id, OBJECT_PRICE, true );
$price            = $price ? (string) $price : ''; // @phpstan-ignore-line
$date             = get_post_meta( $post_id, OBJECT_DATE, true );
$date             = $date ? (string) $date : ''; // @phpstan-ignore-line
$date             = strtotime( $date );
$date             = $date ? (int) $date : 0;
$date             = gmdate( 'm/d/Y', $date );
$permalink        = get_permalink( $post_id );
$vertical_label   = $permalink ? $permalink . 'vertical' : '';
$horizontal_label = $permalink ? $permalink . 'horizontal' : '';

?>

<section id="rosenfield-collection-admin-object-data" class="text-light bg-secondary py-2" role="contentinfo" aria-label="Admin only object data">
	<div class="container-xxl">
		<div class="row justify-content-between">
			<div class="col col-12 col-md-9 admin-only-purchase">
				<?php if ( ! empty( $tags ) ) : ?>
					<?php echo wp_kses_post( $tags ); ?>
					<span class="entry-sep text-white">
						&middot;
					</span>
				<?php endif; ?>

				<?php if ( ! empty( $location ) ) : ?>
					<?php echo wp_kses_post( $location ); ?>
					<span class="entry-sep text-white">
						&middot;
					</span>
				<?php endif; ?>
				
				<?php if ( ! empty( $price ) ) : ?>
					$<?php echo esc_html( $price ); ?>
					<span class="entry-sep text-white">
						&middot;
					</span>
				<?php endif; ?>

				<?php if ( ! empty( $date ) ) : ?>
					<?php echo esc_html( $date ); ?>
				<?php endif; ?>

				</div>
			<div class="col col-12 col-md-3 d-flex justify-content-md-end">
				<a href="<?php echo esc_url( $vertical_label ); ?>" class="link-light link-hidden-dots-light" rel="nofollow">
					<?php echo esc_html__( 'Vertical Label', 'rosenfield-collection' ); ?>
				</a>
				<span class="entry-sep text-white">
					&middot;
				</span>
				<a href="<?php echo esc_url( $horizontal_label ); ?>" class="link-light link-hidden-dots-light" rel="nofollow">
					<?php echo esc_html__( 'Horizontal Label', 'rosenfield-collection' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>