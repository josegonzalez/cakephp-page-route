<?php
/**
 * All PageRoute plugin tests
 */
class AllPageRouteTest extends CakeTestCase {

/**
 * Suite define the tests for this suite
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All PageRoute test');

		$path = CakePlugin::path('PageRoute') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($path);

		return $suite;
	}

}
