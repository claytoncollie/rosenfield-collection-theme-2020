<?php
/**
 * Rosenfield Collection Theme.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Config\PostTypeSupport;

use const RosenfieldCollection\Theme\PostTypes\PAGE_SLUG;
use const RosenfieldCollection\Theme\PostTypes\POST_SLUG;

return [
	'add'    => [
		'hero-section' => [ PAGE_SLUG, POST_SLUG ],
		'excerpt'      => [ PAGE_SLUG, POST_SLUG ],
	],
	'remove' => [
		'genesis-scripts' => [ POST_SLUG ],
		'genesis-layouts' => [ POST_SLUG ],
	],
];
