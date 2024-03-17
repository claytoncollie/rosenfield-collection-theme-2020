<?php
/**
 * Hero
 * 
 * @package RosenfieldCollection\Theme
 */

?>

<section class="bg-light text-center py-3 py-md-5 border-1 border-bottom" aria-label="Page header">
	<div class="container-xxl">
		<?php if ( is_single() ) : ?>
			<div class="row align-items-center justify-content-between">
				<?php do_action( 'genesis_hero_section' ); ?>
			</div>
		<?php else : ?>
			<div class="row">
				<div class="mw-700 mx-auto">
					<?php do_action( 'genesis_hero_section' ); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>