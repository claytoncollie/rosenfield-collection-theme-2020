<?php
/**
 * Template Name: No Hero
 *
 * @package   RosenfieldCollection\Theme2020
 * @link      https://www.rosenfieldcollection.com
 * @author    Clayton Collie
 * @copyright Copyright © 2019 Clayton Collie
 * @license   GPL-2.0-or-later
 */

// Removes hero section.
\remove_theme_support( 'hero-section' );

// Runs the Genesis loop.
genesis();
