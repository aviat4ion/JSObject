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
class JSObject extends ArrayObject {

	/**
	 * Create the object
	 *
	 * @param mixed
	 */
	public function __construct($params = [])
	{
		parent::__construct($params, ArrayObject::ARRAY_AS_PROPS);
	
		foreach($params as $name => &$val)
		{
			// Bind '$this' for closures
			if ($val instanceof Closure)
			{
				$val = $val->bindTo($this);
			}
				
			// Add the parameter to the object
			$this->$name = $val;
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Magic method to invoke appended closures
	 *
	 * @param string
	 * @param array
	 * @return mixed
	 */
	public function __call($name, $params = [])
	{
		// Allow array operations on the object
		if (substr($name, 0, 6) === 'array_' && is_callable($name))
		{
			$args = array_merge($this->getArrayCopy(), $params);
			return call_user_func_array($name, [$args]);
		}
	
		// Call closures attached to the object
		if (is_callable($this->$name))
		{
			return call_user_func_array($this->$name, $params);
		}
		
		return NULL;
	}
}

// End of JSObject.php