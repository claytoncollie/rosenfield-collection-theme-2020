<?php
/**
 * Comments.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Comments;

/**
 * Setup
 */
function setup(): void {
	add_action( 'admin_init', __NAMESPACE__ . '\update_options_page' );
	add_action( 'admin_init', __NAMESPACE__ . '\disable_comments_post_types_support' );
	add_action( 'wp_before_admin_bar_render', __NAMESPACE__ . '\remove_admin_bar_link' );
	add_filter( 'comments_array', __NAMESPACE__ . '\disable_comments_hide_existing_comments', 10, 2 );
	add_action( 'admin_menu', __NAMESPACE__ . '\disable_comments_admin_menu' );
	add_action( 'admin_init', __NAMESPACE__ . '\disable_comments_admin_menu_redirect' );
	add_action( 'admin_init', __NAMESPACE__ . '\disable_comments_dashboard' );
	add_action( 'init', __NAMESPACE__ . '\disable_comments_admin_bar' );
	add_action( 'init', __NAMESPACE__ . '\disable_comments_and_pings' );
	add_action( 'widgets_init', __NAMESPACE__ . '\disable_comments_widget' );
	add_action( 'admin_head', __NAMESPACE__ . '\hide_dashboard_bits' );
}

/**
 * Update fields on options-comments.php
 */
function update_options_page(): void {
	update_option( 'default_pingback_flag', 'closed' );
	update_option( 'default_ping_status', 'closed' );
	update_option( 'default_comment_status', 'closed' );
	update_option( 'show_avatars', 'closed' );
}

/**
 * Disable support for comments and trackbacks in post types
 */
function disable_comments_post_types_support(): void {
	$post_types = get_post_types();
	if ( empty( $post_types ) ) {
		return;
	}

	foreach ( $post_types as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}

/**
 * Remove links/menus from the admin bar
 */
function remove_admin_bar_link(): void {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'comments' );
}

/**
 * Hide existing comments
 */
function disable_comments_hide_existing_comments(): array {
	return [];
}

/**
 * Remove admin pages
 */
function disable_comments_admin_menu(): void {
	remove_menu_page( 'edit-comments.php' );
	remove_submenu_page( 
		'options-general.php',
		'options-discussion.php' 
	);
}

/**
 * Redirect any user trying to access comments page
 */
function disable_comments_admin_menu_redirect(): void {
	global $pagenow;

	if ( 'comment.php' === $pagenow || 'edit-comments.php' === $pagenow || 'options-discussion.php' === $pagenow ) {
		wp_die( 
			esc_html__( 'Comments are closed.', 'rosenfield-collection' ),
			'',
			[ 
				'response' => 403,
			] 
		);
	}
}

/**
 * Remove comments metabox from dashboard
 */
function disable_comments_dashboard(): void {
	remove_meta_box( 
		'dashboard_recent_comments',
		'dashboard',
		'normal' 
	);
}

/**
 * Remove comments metabox from dashboard
 */
function disable_comments_and_pings(): void {
	add_filter( 'comments_open', '__return_false', 20, 2 );
	add_filter( 'pings_open', '__return_false', 20, 2 );
}

/**
 * Remove comments links from admin bar
 */
function disable_comments_admin_bar(): void {
	if ( is_admin_bar_showing() ) {
		remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
	}
}

/**
 * Remove comments widget
 */
function disable_comments_widget(): void {
	unregister_widget( 'WP_Widget_Recent_Comments' );
}

/**
 * Hides comments link on dashboard
 */
function hide_dashboard_bits(): void {
	if ( 'dashboard' === get_current_screen()->id ) {
		echo '<script>
			jQuery(function($){
				$("#dashboard_right_now .comment-count, #latest-comments").hide();
				$("#welcome-panel .welcome-comments").parent().hide();
			});
			</script>';
	}
}
