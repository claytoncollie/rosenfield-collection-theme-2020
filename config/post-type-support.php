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
		'excerpt' => [ PAGE_SLUG ],
	],
	'remove' => [
		'genesis-scripts' => [ POST_SLUG, PAGE_SLUG ],
		'genesis-layouts' => [ POST_SLUG, PAGE_SLUG ],
	],
];
