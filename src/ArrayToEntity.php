<?php 
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */
 
namespace sFire\Entity;

use sFire\DataControl\TypeString;


/**
 * Class ArrayToEntity
 * @package sFire\Entity
 */
class ArrayToEntity {
	
	
	/**
	 * Constructor. Injects an data array into an existing object with Setters
	 * @param object $object The object to be injected with the array data
	 * @param array $data The data that needs to be injected
	 */	
	public function __construct($object, array $data) {

		foreach($data as $key => $value) {

		    $method = sprintf('set%s', TypeString::toPascalCase($key));

			if(true === is_callable([$object, $method])) {
				call_user_func_array([$object, $method], [$value]);
			}
		}
	}
}