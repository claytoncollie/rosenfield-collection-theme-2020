<?php
/**
 * Hero.
 *
 * @package   RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Structure\Hero;

use const RosenfieldCollection\Theme\Fields\CONTACT_SLUG;
use const RosenfieldCollection\Theme\PostTypes\PAGE_SLUG;

/**
 * Setup
 */
function setup(): void {
	add_action( 'genesis_meta', __NAMESPACE__ . '\hero_setup' );
}

/**
 * Sets up hero section.
 */
function hero_setup(): void {
	if ( is_admin() ) {
		return;
	}

	if ( is_singular() ) {
		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	}

	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
	remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
	remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_open', 5 );
	remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_close', 15 );
	remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_intro_text', 12 );
	remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
	remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
	remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
	remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
	remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
	remove_action( 'genesis_before_loop', 'genesis_do_search_title' );

	remove_filter( 'genesis_term_intro_text_output', 'wpautop' );
	remove_filter( 'genesis_author_intro_text_output', 'wpautop' );
	remove_filter( 'genesis_cpt_archive_intro_text_output', 'wpautop' );

	add_filter( 'genesis_search_title_output', '__return_false' );

	add_action( 'genesis_hero_section', 'genesis_do_posts_page_heading' );
	add_action( 'genesis_hero_section', 'genesis_do_date_archive_title' );
	add_action( 'genesis_hero_section', 'genesis_do_taxonomy_title_description' );
	add_action( 'genesis_hero_section', 'genesis_do_author_title_description' );
	add_action( 'genesis_hero_section', 'genesis_do_cpt_archive_title_description' );
	add_action( 'genesis_archive_title_descriptions', __NAMESPACE__ . '\do_archive_headings_intro_text', 12, 3 );
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\hero_title', 10 );
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\hero_view_toggle', 15 );
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\hero_search_form', 15 );
	add_action( 'genesis_hero_section', __NAMESPACE__ . '\hero_excerpt', 20 );
	add_action( 'genesis_before_content', __NAMESPACE__ . '\hero_remove_404_title' );
	add_action( 'genesis_after_header', __NAMESPACE__ . '\hero_display' );
}

/**
 * Remove default title of 404 pages.
 */
function hero_remove_404_title(): void {
	if ( is_404() ) {
		add_filter( 'genesis_markup_entry-title_open', '__return_false' );
		add_filter( 'genesis_markup_entry-title_content', '__return_false' );
		add_filter( 'genesis_markup_entry-title_close', '__return_false' );
	}
}

/**
 * Display title in hero section.
 */
function hero_title(): void {
	if ( is_front_page() ) {
		return;
	} 

	$open  = '<h1 %s>';
	$close = '</h1>';

	if ( is_home() && 'posts' === get_option( 'show_on_front' ) ) {
		$title = apply_filters( 'genesis_latest_posts_title', esc_html__( 'Latest Posts', 'rosenfield-collection' ) );
	} elseif ( is_404() ) {
		$title = apply_filters( 'genesis_404_entry_title', esc_html__( 'Not found, error 404', 'rosenfield-collection' ) );
	} elseif ( is_search() ) {
		$title = apply_filters( 'genesis_search_title_text', esc_html__( 'Search Results', 'rosenfield-collection' ) );
	} elseif ( is_page() ) {
		$title = get_the_title();
	} elseif ( is_singular() ) {
		$title     = get_the_title();
		$permalink = get_permalink();
		$permalink = $permalink ? (string) $permalink : '';
		$open      = '<div class="col col-12 col-md-8 text-start d-flex align-items-center flex-column flex-md-row mb-4 mb-md-0"><h1 %s>';
		$close     = sprintf(
			'</h1><span class="entry-sep d-none d-md-inline-block">&middot;</span><a href="%s" class="link-fancy">%s</a></div>',
			esc_url(
				add_query_arg(
					[
						'referrer' => $permalink,
					],
					get_permalink( get_page_by_path( CONTACT_SLUG, OBJECT, PAGE_SLUG ) ) // @phpstan-ignore-line
				)
			),
			esc_html__( 'Suggest an edit', 'rosenfield-collection' )
		);
	}
	if ( ! isset( $title ) ) {
		return;
	}
	if ( ! $title ) {
		return;
	}
	genesis_markup(
		[
			'open'    => $open,
			'close'   => $close,
			'content' => $title,
			'context' => 'hero-title',
		]
	);
}

/**
 * Display page excerpt.
 */
function hero_excerpt(): void {
	if ( is_front_page() ) {
		return;
	} 
	
	$excerpt = '';
	$id      = '';

	if ( is_home() && 'posts' === get_option( 'show_on_front' ) ) {
		$excerpt = apply_filters( 'genesis_latest_posts_subtitle', esc_html__( 'Showing the latest posts', 'rosenfield-collection' ) );
	} elseif ( is_home() ) {
		$id = get_option( 'page_for_posts' );
	} elseif ( is_search() ) {
		// phpcs:ignore WordPress.VIP.RestrictedFunctions.get_page_by_path_get_page_by_path
		$id = get_page_by_path( 'search' );
	} elseif ( is_404() ) {
		// phpcs:ignore WordPress.VIP.RestrictedFunctions.get_page_by_path_get_page_by_path
		$id = get_page_by_path( 'error-404' );
	} elseif ( ( is_singular() ) && ! is_singular( 'product' ) ) {
		$id = get_the_ID();
	}

	if ( $id ) {
		$excerpt = has_excerpt( (int) $id ) ? do_shortcode( get_the_excerpt( (int) $id ) ) : ''; // @phpstan-ignore-line
	}

	if ( empty( $excerpt ) ) {
		return;
	}

	genesis_markup(
		[
			'open'    => '<div class="font-alt fst-italic"><p %s>',
			'close'   => '</p></div>',
			'content' => $excerpt,
			'context' => 'hero-subtitle',
		]
	);
}

/**
 * Display two links for JS to bind to.
 *
 * Will toggle view between grid (default) and list.
 */
function hero_view_toggle(): void {
	if ( ! is_tax() && ! is_tag() ) {
		return;
	}

	get_template_part( 'partials/taxonomy-view' );
}

/**
 * Display search form
 */
function hero_search_form(): void {
	if ( ! is_search() ) {
		return;
	}

	get_template_part( 'partials/search-form' );
}

/**
 * Add intro text for archive headings to archive pages.
 *
 * @param string $heading    Optional. Archive heading, default is empty string.
 * @param string $intro_text Optional. Archive intro text, default is empty string.
 * @param string $context    Optional. Archive context, default is empty string.
 */
function do_archive_headings_intro_text( string $heading = '', string $intro_text = '', string $context = '' ): void {
	if ( '' === $context || '0' === $context ) {
		return;
	}
	if ( '' === $intro_text || '0' === $intro_text ) {
		return;
	}
	genesis_markup(
		[
			'open'    => '<div class="font-alt fst-italic">',
			'close'   => '</div>',
			'content' => $intro_text,
			'context' => 'hero-subtitle',
		]
	);
}

/**
 * Display the hero section.
 */
function hero_display(): void {
	get_template_part( 'partials/hero' );
}
