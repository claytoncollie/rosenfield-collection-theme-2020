<?php
/**
 * Rosenfield Collection Theme.
 *
 * @package RosenfieldCollection\Theme
 */

define( 'ROSENFIELD_COLLECTION_THEME_TEMPLATE_PATH', get_template_directory() );
define( 'ROSENFIELD_COLLECTION_THEME_STYLESHEET_PATH', get_stylesheet_directory() );
define( 'ROSENFIELD_COLLECTION_THEME_STYLESHEET_URL', get_stylesheet_directory_uri() );
define( 'ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH', ROSENFIELD_COLLECTION_THEME_STYLESHEET_PATH . '/includes/' );
define( 'ROSENFIELD_COLLECTION_THEME_DIST_PATH', ROSENFIELD_COLLECTION_THEME_STYLESHEET_PATH . '/dist/' );
define( 'ROSENFIELD_COLLECTION_THEME_DIST_URL', ROSENFIELD_COLLECTION_THEME_STYLESHEET_URL . '/dist/' );

// Bootstrap Genesis theme (do not remove).
require_once ROSENFIELD_COLLECTION_THEME_TEMPLATE_PATH . '/lib/init.php';

// Composer dependencies (do not remove).
if ( file_exists( ROSENFIELD_COLLECTION_THEME_STYLESHEET_PATH . '/vendor/autoload.php' ) ) {
	require ROSENFIELD_COLLECTION_THEME_STYLESHEET_PATH . '/vendor/autoload.php';
}

// Functionality.
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'accessibility.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'admin-columns.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'artists.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'assets.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'comments.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'dashboard.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'fields.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'genesis.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'gravity-forms.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'helpers.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'image-sizes.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'markup.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'object-claim.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'pending.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'post-status.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'post-types.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'print-labels.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'query-vars.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'search.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'setup.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'taxonomies.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'wordpress.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'wp-mail-smtp.php';

// Structure.
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/archive.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/author.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/footer.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/header.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/hero.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/home.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/menus.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/pagination.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/single.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/wrap.php';

// Functionality.
\RosenfieldCollection\Theme\Accessibility\setup();
\RosenfieldCollection\Theme\AdminColumns\setup();
\RosenfieldCollection\Theme\Artists\setup();
\RosenfieldCollection\Theme\Assets\setup();
\RosenfieldCollection\Theme\Comments\setup();
\RosenfieldCollection\Theme\Dashboard\setup();
\RosenfieldCollection\Theme\Fields\setup();
\RosenfieldCollection\Theme\GravityForms\setup();
\RosenfieldCollection\Theme\Genesis\setup();
\RosenfieldCollection\Theme\ImageSizes\setup();
\RosenfieldCollection\Theme\Markup\setup();
\RosenfieldCollection\Theme\ObjectClaim\setup();
\RosenfieldCollection\Theme\Pending\setup();
\RosenfieldCollection\Theme\PostStatus\setup();
\RosenfieldCollection\Theme\PrintLabels\setup();
\RosenfieldCollection\Theme\QueryVars\setup();
\RosenfieldCollection\Theme\Search\setup();
\RosenfieldCollection\Theme\Setup\setup();
\RosenfieldCollection\Theme\Taxonomies\setup();
\RosenfieldCollection\Theme\WordPress\setup();
\RosenfieldCollection\Theme\WpMailSMTP\setup();

// Structure.
\RosenfieldCollection\Theme\Structure\Archive\setup();
\RosenfieldCollection\Theme\Structure\Author\setup();
\RosenfieldCollection\Theme\Structure\Footer\setup();
\RosenfieldCollection\Theme\Structure\Header\setup();
\RosenfieldCollection\Theme\Structure\Hero\setup();
\RosenfieldCollection\Theme\Structure\Home\setup();
\RosenfieldCollection\Theme\Structure\Menus\setup();
\RosenfieldCollection\Theme\Structure\Pagination\setup();
\RosenfieldCollection\Theme\Structure\Single\setup();
\RosenfieldCollection\Theme\Structure\Wrap\setup();
