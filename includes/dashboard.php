<?php
/**
 * Dashboard.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Dashboard;

/**
 * Setup
 */
function setup(): void {
	add_action( 'admin_init', __NAMESPACE__ . '\maybe_disable_dashboard_access' );
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
