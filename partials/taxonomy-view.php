<?php
/**
 * Taxonomy Grid List Toggle
 * 
 * @package RosenfieldCollection\Theme
 */

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

?>

<div class="d-flex align-items-center justify-content-center pt-3">
	<a href="<?php echo esc_url( $term_link ); ?>" class="fs-5 lh-1 d-flex align-items-center fst-italic text-decoration-none" id="view-toggle-grid" aria-label="<?php echo esc_attr__( 'View as grid', 'rosenfield-collection' ); ?>">
		<span class="me-2">
			<?php echo svg( 'border-all-solid' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</span>
		<?php echo esc_html__( 'Grid', 'rosenfield-collection' ); ?>
	</a>
	<span class="entry-sep">
		&middot;
	</span>
	<a href="<?php echo esc_url( add_query_arg( VIEW_VAR, 'list', $term_link ) ); ?>" class="fs-5 lh-1 d-flex align-items-center fst-italic text-decoration-none" id="view-toggle-list" aria-label="<?php echo esc_attr__( 'View as list', 'rosenfield-collection' ); ?>">
		<span class="me-2">
			<?php echo svg( 'list-solid' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</span>
		<?php echo esc_html__( 'List', 'rosenfield-collection' ); ?>
	</a>
</div>
