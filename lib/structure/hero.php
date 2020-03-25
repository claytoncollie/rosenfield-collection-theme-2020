<?php
/**
 * Rosenfield Collection Theme.
 *
 * @package   RosenfieldCollection\Theme2020
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

namespace RosenfieldCollection\Theme2020\Structure;

\add_action( 'genesis_meta', __NAMESPACE__ . '\hero_setup' );
/**
 * Sets up hero section.
 *
 * @since 1.0.0
 *
 * @return void
 */
function hero_setup() {
	if ( \is_admin() || ! \current_theme_supports( 'hero-section' ) || ! \post_type_supports( \get_post_type(), 'hero-section' ) || \genesis_entry_header_hidden_on_current_page() ) {
		return;
	}

	if ( \is_singular() ) {
		\remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	}

	\remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
	\remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
	\remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
	\remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_open', 5 );
	\remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_close', 15 );
	\remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_intro_text', 12 );
	\remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
	\remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
	\remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
	\remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
	\remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
	\remove_action( 'genesis_before_loop', 'genesis_do_search_title' );
	\remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	\remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

	\remove_filter( 'genesis_term_intro_text_output', 'wpautop' );
	\remove_filter( 'genesis_author_intro_text_output', 'wpautop' );
	\remove_filter( 'genesis_cpt_archive_intro_text_output', 'wpautop' );

	\add_filter( 'woocommerce_show_page_title', '__return_null' );
	\add_filter( 'genesis_search_title_output', '__return_false' );
	\add_filter( 'genesis_attr_archive-title', __NAMESPACE__ . '\hero_archive_title_attr' );
	\add_filter( 'genesis_attr_entry', __NAMESPACE__ . '\hero_entry_attr' );
	\add_filter( 'body_class', __NAMESPACE__ . '\hero_body_class' );

	\add_action( 'genesis_hero_section', 'genesis_do_posts_page_heading' );
	\add_action( 'genesis_hero_section', 'genesis_do_date_archive_title' );
	\add_action( 'genesis_hero_section', 'genesis_do_taxonomy_title_description' );
	\add_action( 'genesis_hero_section', 'genesis_do_author_title_description' );
	\add_action( 'genesis_hero_section', 'genesis_do_cpt_archive_title_description' );
	\add_action( 'genesis_archive_title_descriptions', __NAMESPACE__ . '\do_archive_headings_intro_text', 12, 3 );
	\add_action( 'genesis_hero_section', __NAMESPACE__ . '\hero_title', 10 );
	\add_action( 'genesis_hero_section', __NAMESPACE__ . '\hero_view_toggle', 15 );
	\add_action( 'genesis_hero_section', __NAMESPACE__ . '\hero_excerpt', 20 );
	\add_action( 'genesis_before_content', __NAMESPACE__ . '\hero_remove_404_title' );
	\add_action( 'genesis_before_content_sidebar_wrap', __NAMESPACE__ . '\hero_display' );

	if ( ! \is_customize_preview() && \is_front_page() ) {
		\add_action( 'genesis_before_hero-section_wrap', 'the_custom_header_markup' );
	}
}

/**
 * Adds hero utility class to body element.
 *
 * @since 1.0.0
 *
 * @param array $classes List of body classes.
 *
 * @return array
 */
function hero_body_class( array $classes ) : array {
	$classes   = \array_diff( $classes, [ 'no-hero-section' ] );
	$classes[] = 'has-hero-section';

	return $classes;
}

/**
 * Remove default title of 404 pages.
 *
 * @since 1.0.0
 *
 * @return void
 */
function hero_remove_404_title() {
	if ( \is_404() ) {
		\add_filter( 'genesis_markup_entry-title_open', '__return_false' );
		\add_filter( 'genesis_markup_entry-title_content', '__return_false' );
		\add_filter( 'genesis_markup_entry-title_close', '__return_false' );
	}
}

/**
 * Display title in hero section.
 *
 * @since 1.0.0
 *
 * @return void
 */
function hero_title() {
	$open  = '<h1 %s itemprop="headline">';
	$close = '</h1>';

	if ( \class_exists( 'WooCommerce' ) && \is_shop() ) {
		$title = \get_the_title( \wc_get_page_id( 'shop' ) );
	} elseif ( \is_home() && 'posts' === \get_option( 'show_on_front' ) ) {
		$title = \apply_filters( 'genesis_latest_posts_title', esc_html__( 'Latest Posts', 'rosenfield-collection-2020' ) );
	} elseif ( \is_404() ) {
		$title = \apply_filters( 'genesis_404_entry_title', esc_html__( 'Not found, error 404', 'rosenfield-collection-2020' ) );
	} elseif ( \is_search() ) {
		$title = \apply_filters( 'genesis_search_title_text', esc_html__( 'Search Results', 'rosenfield-collection-2020' ) );
	} elseif ( \is_page() ) {
		$title = \get_the_title();
	} elseif ( \is_singular() ) {
		$title = \get_the_title();
		$open  = '<div class="hero-section-edit"><h1 %s itemprop="headline">';
		$close = sprintf(
			'</h1><span class="entry-sep">&middot;</span><a href="%s" class="more-link">%s</a></div>',
			esc_url(
				add_query_arg(
					array(
						'referrer' => get_permalink(),
					),
					get_permalink( get_page_by_path( 'contact', OBJECT, 'page' ) )
				)
			),
			esc_html__( 'Suggest an edit', 'rosenfield-collection-2020' )
		);
	}

	if ( isset( $title ) && $title ) {
		\genesis_markup(
			[
				'open'    => $open,
				'close'   => $close,
				'content' => $title,
				'context' => 'hero-title',
			]
		);
	}
}

/**
 * Display page excerpt.
 *
 * @since 1.0.0
 *
 * @return void
 */
function hero_excerpt() {
	$excerpt = '';
	$id      = '';

	if ( \class_exists( 'WooCommerce' ) && \is_shop() ) {
		\ob_start();
		\woocommerce_result_count();
		$excerpt = \ob_get_clean();
	} elseif ( \is_home() && 'posts' === \get_option( 'show_on_front' ) ) {
		$excerpt = \apply_filters( 'genesis_latest_posts_subtitle', esc_html__( 'Showing the latest posts', 'rosenfield-collection-2020' ) );
	} elseif ( \is_home() ) {
		$id = \get_option( 'page_for_posts' );
	} elseif ( \is_search() ) {
		// phpcs:ignore WordPress.VIP.RestrictedFunctions.get_page_by_path_get_page_by_path
		$id = \get_page_by_path( 'search' );
	} elseif ( \is_404() ) {
		// phpcs:ignore WordPress.VIP.RestrictedFunctions.get_page_by_path_get_page_by_path
		$id = \get_page_by_path( 'error-404' );
	} elseif ( ( \is_singular() ) && ! \is_singular( 'product' ) ) {
		$id = \get_the_ID();
	}

	if ( $id ) {
		$excerpt = \has_excerpt( $id ) ? \do_shortcode( \get_the_excerpt( $id ) ) : '';
	}

	if ( $excerpt ) {
		\genesis_markup(
			[
				'open'    => '<p %s itemprop="description">',
				'close'   => '</p>',
				'content' => $excerpt,
				'context' => 'hero-subtitle',
			]
		);
	}
}

/**
 * Dispaly two links for JS to bind to.
 *
 * Will toggle view between grid (default) and list.
 *
 * @return void
 *
 * @since 1.0.0
 */
function hero_view_toggle() {
	global $wp_query;

	if ( ! is_tax() && ! is_tag() ) {
		return;
	}

	$taxonomy = $wp_query->get_queried_object();

	printf(
		'<section class="view-toggle"><a href="%s" id="view-toggle-grid">%s</a><span class="entry-sep">&middot;</span><a href="%s" id="view-toggle-list">%s</a></section>',
		esc_url( get_term_link( absint( $taxonomy->term_id ), $taxonomy->taxonomy ) ),
		esc_html__( 'Grid', 'rosenfield-collection-2020' ),
		esc_url( add_query_arg( 'view', 'list', get_term_link( absint( $taxonomy->term_id ), $taxonomy->taxonomy ) ) ),
		esc_html__( 'List', 'rosenfield-collection-2020' )
	);
}

/**
 * Add intro text for archive headings to archive pages.
 *
 * @since 1.0.0
 *
 * @param string $heading    Optional. Archive heading, default is empty string.
 * @param string $intro_text Optional. Archive intro text, default is empty string.
 * @param string $context    Optional. Archive context, default is empty string.
 *
 * @return void
 */
function do_archive_headings_intro_text( string $heading = '', string $intro_text = '', string $context = '' ) {
	if ( $context && $intro_text ) {
		\genesis_markup(
			[
				'open'    => '<p %s itemprop="description">',
				'close'   => '</p>',
				'content' => $intro_text,
				'context' => 'hero-subtitle',
			]
		);
	}
}

/**
 * Adds attributes to hero archive title markup.
 *
 * @since 1.0.0
 *
 * @param array $atts Hero title attributes.
 *
 * @return array
 */
function hero_archive_title_attr( array $atts ) : array {
	$atts['class']    = 'hero-title';
	$atts['itemprop'] = 'headline';

	return $atts;
}

/**
 * Adds attributes to hero section markup.
 *
 * @since 1.0.0
 *
 * @param array $atts Hero entry attributes.
 *
 * @return array
 */
function hero_entry_attr( array $atts ) : array {
	if ( \is_singular() ) {
		$atts['itemref'] = 'hero-section';
	}

	return $atts;
}

/**
 * Display the hero section.
 *
 * @since 1.0.0
 *
 * @return void
 */
function hero_display() {
	\genesis_markup(
		[
			'open'    => '<section %s role="banner">',
			'context' => 'hero-section',
		]
	);

	\do_action( 'genesis_before_hero_section' );

	\genesis_structural_wrap( 'hero-section', 'open' );

	\genesis_markup(
		[
			'open'    => '<div %s>',
			'context' => 'hero-inner',
		]
	);

	\do_action( 'genesis_hero_section' );

	\genesis_markup(
		[
			'close'   => '</div>',
			'context' => 'hero-inner',
		]
	);

	\genesis_structural_wrap( 'hero-section', 'close' );

	\do_action( 'genesis_after_hero_section' );

	\genesis_markup(
		[
			'close'   => '</section>',
			'context' => 'hero-section',
		]
	);
}
