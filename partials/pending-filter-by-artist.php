<?php
/**
 * Pending Filter by Artist
 * 
 * @package RosenfieldCollection\Theme
 */

use const RosenfieldCollection\Theme\Fields\PENDING_SLUG;
use const RosenfieldCollection\Theme\PostTypes\PAGE_SLUG;
use const RosenfieldCollection\Theme\QueryVars\ARTIST_VAR;

$users = get_users(
	[
		'order'   => 'ASC',
		'orderby' => 'display_name',
	]
);

if ( empty( $users ) ) {
	return;
}

$post = get_page_by_path( PENDING_SLUG, OBJECT, PAGE_SLUG );
if ( empty( $post ) ) {
	return;
}

$permalink = get_permalink( $post );
$permalink = '' !== $permalink && '0' !== $permalink ? (string) $permalink : '';

?>

<div class="col" aria-label="Filter object by artist">
	<select onchange="document.location.href=this.value" class="form-select">
		<option value="<?php echo esc_url( $permalink ); ?>">
			<?php echo esc_html__( 'All Artists', 'rosenfield-collection' ); ?>
		</option>

		<?php 
		foreach ( $users as $user ) : 
			$user_link   = add_query_arg(
				ARTIST_VAR,
				$user->ID,
				get_permalink()
			);
			$is_selected = get_query_var( ARTIST_VAR ) === (string) $user->ID ? 'selected' : '';
			$user_name   = ucwords( (string) $user->display_name );
			?>
			<option value="<?php echo esc_url( $user_link ); ?>" <?php echo esc_attr( $is_selected ); ?>>
				<?php echo esc_html( $user_name ); ?>
			</option>
		<?php endforeach; ?>
	</select>
</div>