<?php
/**
 * Taxonomy Loop
 * 
 * @package RosenfieldCollection\Theme
 */

use function RosenfieldCollection\Theme\Helpers\column_class;

use const RosenfieldCollection\Theme\ImageSizes\IMAGE_ARCHIVE;
use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;

$taxonomy = $args['taxonomy'] ?? '';
if ( empty( $taxonomy ) ) {
	return;
}

$terms = get_categories( 
	[
		'taxonomy'   => $taxonomy,
		'post_type'  => POST_SLUG,
		'title_li'   => '',
		'depth'      => 1,
		'hide_empty' => 1,
		'images'     => 1,
	]
);

if ( empty( $terms ) ) {
	return;
}

$index = 0;

?>

<?php 
foreach ( $terms as $term ) :
	$column_class = column_class( $index, 4 );
	$term_slug    = $term->slug;
	$term_name    = $term->name;
	$term_count   = $term->count;
	$term_link    = get_term_link( $term );
	$term_link    = ! empty( $term_link ) && ! is_wp_error( $term_link ) ? (string) $term_link : '';
	
	$posts = get_posts( 
		[
			'tax_query'   => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				[
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $term_slug,
				],
			],
			'post_type'   => POST_SLUG,
			'numberposts' => 1,
			'meta_query'  => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				[
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS',
				],
			],
		]
	);
	
	$image = get_the_post_thumbnail(
		(int) $posts[0]->ID,
		IMAGE_ARCHIVE,
		[
			'alt' => sprintf(
				'%s %s',
				esc_html__( 'Newest object from category:', 'rosenfield-collection' ),
				esc_html( $term_name )
			),
		]
	);
	?>

	<article class="entry one-fourth <?php echo esc_attr( $column_class ); ?>" aria-label="Category: <?php echo esc_attr( $term_name ); ?>">
		<?php if ( ! empty( $image ) ) : ?>	
			<a href="<?php echo esc_url( $term_link ); ?>" rel="bookmark" itemprop="url" class="entry-image-link">
				<?php echo wp_kses_post( $image ); ?>
			</a>
		<?php endif; ?>
		<div class="entry-wrap">
			<header class="entry-header">
				<h2 class="entry-title" itemprop="headline">
					<a href="<?php echo esc_url( $term_link ); ?>">
						<?php echo esc_html( $term_name ); ?>
					</a>
				</h2>
				<a class="more-link" href="<?php echo esc_url( $term_link ); ?>" aria-label="View Category: <?php echo esc_attr( $term_name ); ?>">
					<?php echo esc_html__( 'View All', 'rosenfield-collection' ); ?>
				</a>
				<span class="entry-sep">
					&middot;
				</span>
				<?php echo esc_html( $term_count ); ?>
			</header>
		</div>
	</article>

	<?php ++$index; ?>
<?php endforeach; ?>
