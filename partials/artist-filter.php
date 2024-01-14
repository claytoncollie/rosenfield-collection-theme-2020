<?php
/**
 * Artist Filter
 * 
 * @package RosenfieldCollection\Theme
 */

use const RosenfieldCollection\Theme\Artists\QUERY_VAR;
use const RosenfieldCollection\Theme\Fields\ARTIST_SLUG;
use const RosenfieldCollection\Theme\PostTypes\PAGE_SLUG;

$field = get_field_object( 'field_5e17ad49aa83c' );
if ( empty( $field ) ) {
	return;
}

$letters = $field['choices'] ?? [];
if ( empty( $letters ) ) {
	return;
}

$is_archive  = get_query_var( QUERY_VAR ) === '' ? 'current' : '';
$page_object = get_page_by_path( ARTIST_SLUG, OBJECT, PAGE_SLUG );
$view_all    = (string) get_permalink( $page_object ); // @phpstan-ignore-line

?>

<section id="rosenfield-collection-artist-filter" class="inline-filter" role="navigation" aria-label="Filter artists by last name">
	<ul>
		<li class="<?php echo esc_attr( $is_archive ); ?>">
			<a href="<?php echo esc_url( $view_all ); ?>">
				<span class="screen-reader-text">
					<?php echo esc_html__( 'Go to page ', 'rosenfield-collection' ); ?>
				</span>
				<?php echo esc_html__( 'All Artists', 'rosenfield-collection' ); ?>
			</a>
		</li>

		<?php 
		foreach ( (array) $letters as $letter ) : 
			$is_current = get_query_var( QUERY_VAR ) === $letter ? 'current' : '';
			$permalink  = add_query_arg(
				QUERY_VAR,
				$letter,
				(string) get_permalink()
			)
			?>
			<li class="<?php echo esc_attr( $is_current ); ?>">
				<a href="<?php echo esc_url( $permalink ); ?>">
					<span class="screen-reader-text">
						<?php echo esc_html__( 'Filter artist by the letter ', 'rosenfield-collection' ); ?>
					</span> 
					<?php echo esc_html( ucwords( (string) $letter ) ); // @phpstan-ignore-line ?>
				</a>
			</li>
<?php endforeach; ?>
	</ul>
</section>