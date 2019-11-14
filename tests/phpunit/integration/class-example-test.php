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

namespace RosenfieldCollection\Theme2020\Tests\Integration;

/**
 * Class Example_Test
 *
 * @package RosenfieldCollection\Theme2020\Tests\Integration
 */
class Example_Test extends \WP_UnitTestCase {

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function test_it_works() {
		$this->assertTrue( \function_exists( 'do_action' ) );
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function test_wp_phpunit_is_loaded_via_composer() {
		$this->assertContains(
			'vendor',
			getenv( 'WP_PHPUNIT__DIR' )
		);
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function test_true_is_true() {
		$this->assertTrue( true );
		$this->assertFalse( false );
	}

	/**
	 * Description of expected behavior.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function test_if_genesis_is_active() {
		$this->assertTrue( \function_exists( 'genesis' ) );
	}
}
