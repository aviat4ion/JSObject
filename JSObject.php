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
// ! Shortcut Function
// --------------------------------------------------------------------------

/**
 * Returns an instance of a JSObject instantiated with the passed parameters
 *
 * @param mixed
 * @return JSObject
 */
function JSObject()
{
	// Create the object
	$obj = new JSObject();
	
	// Set the parameters
	call_user_func_array([$obj, '__construct'], func_get_args());
	return $obj;
}

// -------------------------------------------------------------------------

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
	
		foreach($params as $name => $val)
		{
			if (empty($val)) continue;
		
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
		$function_blacklist = [
			'array_change_key_case',
			'array_combine',
			'array_count_values',
			'array_fill_keys',
			'array_fill',
			'array_key_exists',
			'array_map',
			'array_merge',
			'array_merge_recursive',
			'array_search',
			'array_unshift',
		];
	
		// Allow array operations on the object
		if (substr($name, 0, 6) === 'array_' && is_callable($name) && ! in_array($name, $function_blacklist))
		{
			$args = ( ! empty($params)) 
				? array_merge($this->getArrayCopy(), $params)
				: $this->getArrayCopy();
			
			// Make sure the array items in the array parameter aren't used as function parameters
			if (count($args === 1))
			{
				$args = [$args];
			}
			
			return call_user_func_array($name, $args);
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