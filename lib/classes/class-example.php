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

namespace RosenfieldCollection\Theme2020;

/**
 * Example Class.
 *
 * This is an example class to demonstrate the class autoloader. Autoloading classes
 * saves you from having `require` calls throughout your theme. To test that this
 * class is loading correctly, place the following in your functions.php file:
 *
 * ```
 * $example = new \RosenfieldCollection\Theme2020\Example();
 * $example->print_name();
 * ```
 *
 * If you have added additional classes to the `lib/classes` directory, you will need
 * to run the `composer dump --no-dev` command from the terminal to regenerate the
 * Composer autoloader files so that your new classes are loaded automatically.
 *
 * @package RosenfieldCollection\Theme2020
 */
class Example {

	/**
	 * Example property.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Example constructor.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		$this->name = __CLASS__;
	}

	/**
	 * Example method.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function print_name() {
		print esc_html( $this->name );
	}
}
