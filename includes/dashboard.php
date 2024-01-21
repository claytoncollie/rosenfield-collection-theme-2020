<?php
/**
 * Dashboard.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Dashboard;

use WP_Query;

use const RosenfieldCollection\Theme\Fields\OBJECT_ID;
use const RosenfieldCollection\Theme\Fields\OBJECT_PRICE;
use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;
use const RosenfieldCollection\Theme\Taxonomies\FORM;

/**
 * Setup
 */
function setup(): void {
	add_action( 'admin_init', __NAMESPACE__ . '\maybe_disable_dashboard_access' );
	add_action( 'admin_init', __NAMESPACE__ . '\remove_dashboard_widgets' );
	add_action( 'admin_init', __NAMESPACE__ . '\set_dashboard_meta_order' );
	add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\custom_dashboard_widgets' );
}

/**
 * Dashboard Redirect for author and below.
 * 
 * Allow editor and admin to access the dashboard.
 */
function maybe_disable_dashboard_access(): void {
	if ( ! is_admin() ) {
		return;
	}
	if ( current_user_can( 'edit_others_posts' ) ) {
		return;
	}

	wp_safe_redirect( home_url() );
	exit;
}

/**
 * Dashboard widgets
 */
function remove_dashboard_widgets(): void {
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
	remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
	remove_meta_box( 'wpe_dify_news_feed', 'dashboard', 'normal' );
	remove_action( 'welcome_panel', 'wp_welcome_panel' );
	remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'normal' );
}

/**
 * Custom dashboard
 */
function custom_dashboard_widgets(): void {
	wp_add_dashboard_widget(
		'rc_introduction',
		__( 'Introduction', 'rosenfield-collection' ),
		__NAMESPACE__ . '\introduction'
	);

	wp_add_dashboard_widget(
		'rc_object_id',
		__( 'Latest ID', 'rosenfield-collection' ),
		__NAMESPACE__ . '\object_id'
	);

	wp_add_dashboard_widget(
		'rc_object_status',
		__( 'Status', 'rosenfield-collection' ),
		__NAMESPACE__ . '\object_status'
	);

	wp_add_dashboard_widget(
		'rc_total_cost',
		__( 'Cost', 'rosenfield-collection' ),
		__NAMESPACE__ . '\total_cost'
	);
}

/**
 * Set the dashboard widget order for all users.
 */
function set_dashboard_meta_order(): void {
	$user_id = get_current_user_id();
	if ( empty( $user_id ) ) {
		return;
	}

	update_user_meta( 
		$user_id,
		'meta-box-order_dashboard',
		[
			'normal'  => 'rc_introduction',
			'side'    => 'rc_object_id',
			'column3' => 'rc_object_status,rc_total_cost',
		]
	);
}

/**
 * Introduction Widget
 */
function introduction(): void {
	$pages = [
		'checkin' => __( 'For when a piece is first entered into the collection and needs the bare minimum amount of information along with a quick photo.', 'rosenfield-collection' ),
		'pending' => __( 'For when a piece is checked into the collection and needs to move out of the kitchen and into the storage area. Most pieces on this page only have a photo and an artist name.', 'rosenfield-collection' ),
		'manage'  => __( 'For when entering a complete object into the collection. Use for after a pieces has all of their photos taken and all information compiled. Use this page if you cannot find it on the PENDING page listed above.', 'rosenfield-collection' ),
	];

	foreach ( $pages as $path => $description ) {
		$page = get_page_by_path( $path, OBJECT, 'page' );
		if ( ! empty( $page ) ) {
			printf(
				'<section style="display:block;margin-bottom:2em";><p>%s</p><a href="%s" target="_blank" class="button button-primary button-large">%s</a></section>',
				esc_html( $description ),
				esc_url( get_permalink( $page ) ),
				esc_html( get_the_title( $page ) )
			);
		}
	}
}

/**
 * Display the latest 10 pieces so we know where to start our next part.
 */
function object_id(): void {
	$terms = get_terms(
		[
			'taxonomy'   => FORM,
			'hide_empty' => false,
		]
	);

	if ( ! empty( $terms ) ) {

		foreach ( $terms as $term ) {

			$posts = [];

			$query = new WP_Query(
				[
					'post_type'   => POST_SLUG,
					'post_status' => 'any',
					'nopaging'    => true, // phpcs:ignore WordPressVIPMinimum.Performance.NoPaging.nopaging_nopaging
					'tax_query'   => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
						[
							'taxonomy' => FORM,
							'field'    => 'slug',
							'terms'    => esc_html( $term->slug ),
						],
					],
				]
			);

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$object_id = get_field( OBJECT_ID, get_the_ID() );

					if ( ! empty( $object_id ) ) {
						$posts[] .= $object_id;
					}
				}
				wp_reset_postdata();

				if ( ! empty( $posts ) ) {

					// Sort descending.
					rsort( $posts );

					// Grab fist 10 elements.
					$posts = array_slice( $posts, 0, 10, true );

					printf( '%s: <strong>%s</strong><hr>', esc_html( $term->name ), esc_html( implode( ', ', $posts ) ) );

				}
			}
		}
	}
}

/**
 * Display all posts broken out by post status
 */
function object_status(): void {
	$stati = [
		[
			'label'    => __( 'Published', 'rosenfield-collection' ),
			'callback' => wp_count_posts()->publish,
		],
		[
			'label'    => __( 'Draft', 'rosenfield-collection' ),
			'callback' => wp_count_posts()->draft,
		],
		[
			'label'    => __( 'Pending', 'rosenfield-collection' ),
			'callback' => wp_count_posts()->pending,
		],
		[
			'label'    => __( 'Archived', 'rosenfield-collection' ),
			'callback' => wp_count_posts()->archive,
		],
	];

	printf(
		'<table class="widefat striped"><thead><tr><td><strong>%s</strong></td><td><strong>%s</strong></td></tr></thead>',
		esc_html__( 'Status', 'rosenfield-collection' ),
		esc_html__( 'Count', 'rosenfield-collection' )
	);

	foreach ( $stati as $status ) {
			printf(
				'<tr><td>%s</td><td>%s</td></tr>',
				esc_html( $status['label'] ),
				esc_html( $status['callback'] )
			);
	}
	echo '</table>';
}

/**
 * Display the total cost of each taxonomy term.
 */
function total_cost(): void {

	$terms = get_terms(
		[
			'taxonomy'   => FORM,
			'hide_empty' => false,
		]
	);

	if ( ! empty( $terms ) ) {

		printf(
			'<table class="widefat striped"><thead><tr><td><strong>%s</strong></td><td><strong>%s</strong></td></tr></thead>',
			esc_html__( 'Form', 'rosenfield-collection' ),
			esc_html__( 'Cost', 'rosenfield-collection' )
		);

		printf(
			'<tr><td>%s</td><td>$%s</td></tr>',
			esc_html__( 'Collection', 'rosenfield-collection' ),
			esc_html( get_total_purchase_price() )
		);

		foreach ( $terms as $term ) {
			printf(
				'<tr><td>%s</td><td>$%s</td></tr>',
				esc_html( $term->name ),
				esc_html( get_taxonomy_purchase_price( absint( $term->term_id ) ) )
			);
		}

		echo '</table>';

	}
}

/**
 * Get the total purchase price for a single taxonomy term.
 *
 * Returns as a float in money format for the USD.
 *
 * @param integer $term_id Term ID.
 * @param string  $taxonomy Taxonomy slug.
 */
function get_taxonomy_purchase_price( int $term_id, string $taxonomy = FORM ): float {
	$output = '0';
	$total  = [];

	$query = new WP_Query(
		[
			'post_type' => POST_SLUG,
			'nopaging'  => true, // phpcs:ignore WordPressVIPMinimum.Performance.NoPaging.nopaging_nopaging
			'tax_query' => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				[
					'taxonomy' => $taxonomy,
					'field'    => 'term_id',
					'terms'    => $term_id,
				],
			],
		]
	);

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			$price = get_field( OBJECT_PRICE );

			if ( ! empty( $price ) ) {
				$total[] .= $price;
			}
		}
		wp_reset_postdata();

		$output = array_sum( $total );
	}

	return number_format( round( (float) $output, 2, PHP_ROUND_HALF_ODD ), 2, '.', '' );
}

/**
 * Get the total collection purchase price from all taxonomies.
 */
function get_total_purchase_price(): float {
	$output = [];
	$terms  = get_terms( FORM );

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$output[] .= get_taxonomy_purchase_price( absint( $term->term_id ) );
		}

		$output = array_sum( $output );
	}

	return number_format( round( (float) $output, 2, PHP_ROUND_HALF_ODD ), 2, '.', '' );
}
