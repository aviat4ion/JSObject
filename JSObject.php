<?php
/**
 * JSObject
 * 
 * A PHP class to have an analoge to javascript's object literals
 *
 * @package		JSObject
 * @author		Timothy J. Warren
 * @copyright	Copyright (c) 2012
 * @link		https://github.com/aviat4ion/JSObject
 */
 
// --------------------------------------------------------------------------

/**
 * JSObject class
 *
 * @package JSObject
 */
class JSObject {

	/**
	 * Create the object
	 *
	 * @param mixed
	 */
	public function __construct($params = [])
	{
		foreach($params as $name => &$val)
		{
			// Bind '$this' for closures
			if ($val instanceof Closure)
			{
				$val->bindTo($this);
			}
		
			// Add the parameter to the object
			$this->$name = $val;
		}
	}
	
	/**
	 * Magic method to invoke appended closures
	 *
	 * @param string
	 * @param array
	 * @return mixed
	 */
	public function __call($name, $params = [])
	{
		if (is_callable($this->$name))
		{
			return call_user_func_array($this->$name, $params);
		}
		
		return NULL;
	}
	
	/**
	 * Treat invokation of the object as creating a new object
	 *
	 * @param mixed
	 * @return JSObject
	 */
	public function __invoke($params = [])
	{
		$class = __CLASS__;
		
		// Create the new object
		$obj = new $class();
		
		// Pass the parameters to the constructor of the new object
		$obj = call_user_func_array([$obj, '__construct'], $params);
		
		return $obj;		
	}
}

// End of JSObject.php