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
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'helpers.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'setup.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'assets.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'markup.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'header.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'widgets.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'search.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'taxonomies.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'artists.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'statistics.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'post-title.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'post-meta-admin.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'view-all-objects.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'image-gallery.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'post-meta.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'thumbnail-gallery.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'list-view.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'image-sizes.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'pending.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'pending-filter.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'claim-object.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'query-vars.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'skip-links.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'accessibility.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'labels.php';

// Structure.
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/hero.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/home.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/wrap.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/menus.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/author.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/footer.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/header.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/single.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/archive.php';
require_once ROSENFIELD_COLLECTION_THEME_INCLUDES_PATH . 'structure/pagination.php';

// Functionality.
\RosenfieldCollection\Theme\Accessibility\setup();
\RosenfieldCollection\Theme\Assets\setup();
\RosenfieldCollection\Theme\Artists\setup();
\RosenfieldCollection\Theme\ClaimObject\setup();
\RosenfieldCollection\Theme\ImageGallery\setup();
\RosenfieldCollection\Theme\ImageSizes\setup();
\RosenfieldCollection\Theme\ListView\setup();
\RosenfieldCollection\Theme\Markup\setup();
\RosenfieldCollection\Theme\PostTitle\setup();
\RosenfieldCollection\Theme\QueryVars\setup();
\RosenfieldCollection\Theme\Search\setup();
\RosenfieldCollection\Theme\Setup\setup();
\RosenfieldCollection\Theme\SkipLinks\setup();
\RosenfieldCollection\Theme\Statistics\setup();
\RosenfieldCollection\Theme\Widgets\setup();

// Structure.
\RosenfieldCollection\Theme\Structure\Hero\setup();
\RosenfieldCollection\Theme\Structure\Home\setup();
\RosenfieldCollection\Theme\Structure\Wrap\setup();
\RosenfieldCollection\Theme\Structure\Menus\setup();
\RosenfieldCollection\Theme\Structure\Author\setup();
\RosenfieldCollection\Theme\Structure\Footer\setup();
\RosenfieldCollection\Theme\Structure\Header\setup();
\RosenfieldCollection\Theme\Structure\Single\setup();
\RosenfieldCollection\Theme\Structure\Archive\setup();
\RosenfieldCollection\Theme\Structure\Pagination\setup();
