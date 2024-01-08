<?php
/**
 * Image Sizes.
 *
 * @package RosenfieldCollection\Theme
 */

namespace RosenfieldCollection\Theme\Config\ImagesSizes;

use const RosenfieldCollection\Theme\ImageSizes\IMAGE_OBJECT;
use const RosenfieldCollection\Theme\ImageSizes\IMAGE_ARCHIVE;

return [
	'add'    => [
		IMAGE_OBJECT  => [ 1536, 1536, false ],
		IMAGE_ARCHIVE => [ 440, 440, true ],
	],
	'remove' => [
		'medium',
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	],
];
