<?php
/**
 * JSObject tests
 *
 * Requires simpletest - Either in PHP path, 
 * or in the folder with the test file
 */
 
// --------------------------------------------------------------------------

// Include simpletest
// it has to be set in your php path, or put in the tests folder
require_once('simpletest/autorun.php');

// Include JSObject
require_once('JSObject.php');

class JSObjectTests extends UnitTestCase {

	function TestIsA() 
	{
		$obj = new JSObject([
			'x' => [0,1,2]
		]);
	
		$this->assertIsA($obj, 'ArrayObject');
		$this->assertIsA($obj, 'JSObject');
	}

	function TestClosure()
	{
		$obj = new JSObject([
			'a' => 10,
			'b' => 5,
			'c' => 0,
			'x' => function() {
				return $this->a * $this->b;
			}
		]);
		
		$this->assertEqual($obj->x(), 50);
	}
	
	function TestArrayFlip()
	{
		$obj = new JSObject([
			'x' => 'foo',
			'y' => 'bar'
		]);
		
		$this->assertEqual($obj->array_flip(), ['foo' => 'x', 'bar' => 'y']);
	}
	
	function TestArrayKeys()
	{
		$obj = new JSObject([
			'x' => 'foo',
			'y' => 'bar'
		]);
		
		$this->assertEqual($obj->array_keys(), ['x','y']);
	}

}