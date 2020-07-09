<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

namespace sFire\Entity;

use stdClass;


/**
 * Class EntityAbstract
 * @package sFire\Entity
 */
abstract class EntityAbstract {


    /**
     * Converts all getters to an Array
     * @param array $set
     * @param bool $convert
     * @return null|array
     */
    public function toArray(array $set = [], bool $convert = true): ?array {

        $methods = get_class_methods($this);
        $array 	 = [];
        $set 	 = array_flip($set);
        $amount  = count($set);

        foreach($methods as $method) {

            $chunks = explode('get', $method);

            if(count($chunks) == 2) {

                $key = (true === $convert) ? strtolower($chunks[1]) : $chunks[1];

                if($amount === 0 || ($amount > 0 && true === isset($set[$key]))) {

                    $value = call_user_func_array([$this, $method], []);

                    if(0 === strlen(trim($key)) && ($value === null || 0 === strlen(trim($value)))) {
                        continue;
                    }

                    $array[$key] = $value;
                }
            }
        }

        return json_decode(json_encode($array, JSON_INVALID_UTF8_IGNORE), true);
    }


    /**
     * Converts all getters to a JSON string
     * @param array $set
     * @param bool $convert
     * @return string
     */
    public function toJson(array $set = [], bool $convert = true): string {
        return json_encode($this -> toArray($set, $convert), JSON_INVALID_UTF8_IGNORE);
    }


    /**
     * Converts all getters to a stdClass object
     * @param array $set
     * @param bool $convert
     * @return stdClass
     */
    public function toObject(array $set = [], bool $convert = true): object {
        return (object) $this -> toArray($set, $convert);
    }
}