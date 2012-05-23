JSObject
========

A PHP 5.4 class to emulate Javascript object literals.

Also, can use ``array_`` functions to operate on the object's properties and values. (Only works for functions that start with ``array_`` and have the array as the first parameter)

Examples:

* Basic Usage

		$obj = new JSObject([
			'a' => 10,
			'b' => 5,
			'c' => 0,
			'x' => function() {
				return $this->a * $this->b;
			}
		]);
		
		$obj->x(); // Returns 50
		
* Get an array of the properties of the object:

		$obj = new JSObject([
			'x' => 'foo',
			'y' => 'bar'
		]);
		
		$obj->array_keys() // Returns: array('x', 'y')

		
		
