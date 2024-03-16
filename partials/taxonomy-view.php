<?php
/**
 * Taxonomy Grid List Toggle
 * 
 * @package RosenfieldCollection\Theme
 */

use function RosenfieldCollection\Theme\Helpers\is_list_view;
use function RosenfieldCollection\Theme\Helpers\svg;

use const RosenfieldCollection\Theme\QueryVars\VIEW_VAR;

global $wp_query;

$taxonomy = $wp_query->get_queried_object();
if ( empty( $taxonomy ) ) {
	return;
}

$term_link = get_term_link( $taxonomy->term_id, $taxonomy->taxonomy );
$term_link = is_wp_error( $term_link ) ? '' : (string) $term_link;
if ( empty( $term_link ) ) {
	return;
}

$is_grid = is_list_view() ? '' : 'active';
$is_list = is_list_view() ? 'active' : '';

?>

<div class="pt-3 btn-group">
	<a href="<?php echo esc_url( $term_link ); ?>" class="d-flex align-items-center  btn btn-outline-primary <?php echo esc_attr( $is_grid ); ?>" aria-label="<?php echo esc_attr__( 'View as grid', 'rosenfield-collection' ); ?>">
		<span class="me-2 lh-1">
			<?php echo svg( 'border-all-solid' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</span>
		<?php echo esc_html__( 'Grid', 'rosenfield-collection' ); ?>
	</a>
	<a href="<?php echo esc_url( add_query_arg( VIEW_VAR, 'list', $term_link ) ); ?>" class="d-flex align-items-center  btn btn-outline-primary <?php echo esc_attr( $is_list ); ?>" aria-label="<?php echo esc_attr__( 'View as list', 'rosenfield-collection' ); ?>">
		<span class="me-2 lh-1">
			<?php echo svg( 'list-solid' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</span>
		<?php echo esc_html__( 'List', 'rosenfield-collection' ); ?>
	</a>
</div>
