<?php
/**
 * Copyright
 * 
 * @package RosenfieldCollection\Theme
 */

$menu = genesis_get_nav_menu( 
	[ 
		'theme_location' => 'secondary',
		'menu_class'     => 'menu list-unstyled mb-0',
	] 
) ?? '';

?>

<div class="col col-12 col-md-6" id="rosenfield-collection-footer-credits" aria-label="<?php echo esc_attr__( 'Footer Credits', 'rosenfield-collection' ); ?>">
	<span class="d-block d-md-inline-block">
		<?php echo do_shortcode( '[footer_copyright]' ); ?> 
		<?php echo esc_html__( 'All Rights Reserved', 'rosenfield-collection' ); ?>
	</span>
	<span class="d-none d-md-inline-block entry-sep">
		&middot;
	</span>
	<span class="d-block d-md-inline-block">
		<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
	</span>
	<span class="d-none d-md-inline-block entry-sep">
		&middot;
	</span>
	<span class="d-block d-md-inline-block">
		<?php echo do_shortcode( '[footer_loginout]' ); ?>
	</span>
</div>
<div class="col col-12 col-md-6 d-md-flex justify-content-md-end">
	<?php echo wp_kses_post( $menu ); ?>
</div>
