<?php
/**
 * Pending Filter by Form
 * 
 * @package RosenfieldCollection\Theme
 */

use const RosenfieldCollection\Theme\Fields\PENDING_SLUG;
use const RosenfieldCollection\Theme\PostTypes\PAGE_SLUG;
use const RosenfieldCollection\Theme\Taxonomies\FORM;

$terms = get_terms(
	[
		'taxonomy'   => FORM,
		'hide_empty' => false,
	]
);
if ( ! $terms ) {
	return;
}
if ( is_wp_error( $terms ) ) {
	return;
}
if ( ! is_array( $terms ) ) {
	return;
}

$post = get_page_by_path( PENDING_SLUG, OBJECT, PAGE_SLUG );
if ( empty( $post ) ) {
	return;
}

$permalink = get_permalink( $post );
$permalink = '' !== $permalink && '0' !== $permalink ? (string) $permalink : '';

?>

<section id="rosenfield-collection-pending-filter-by-form" class="inline-filter" role="navigation" aria-label="Filter object by form">
	<select onchange="document.location.href=this.value">
		<option value="<?php echo esc_url( $permalink ); ?>">
			<?php echo esc_html__( 'All Forms', 'rosenfield-collection' ); ?>
		</option>

		<?php 
		foreach ( $terms as $term ) : 
			$term_link   = add_query_arg(
				FORM,
				$term->slug,
				get_permalink()
			);
			$is_selected = get_query_var( FORM ) === $term->slug ? 'selected' : '';
			$term_name   = ucwords( $term->name );
			?>
			<option value="<?php echo esc_url( $term_link ); ?>" <?php echo esc_attr( $is_selected ); ?>>
				<?php echo esc_html( $term_name ); ?>
			</option>
		<?php endforeach; ?>
	</select>
</section>
