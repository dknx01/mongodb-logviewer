<?php
/**
 * 
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 13.02.15 14:30
 * @package
 * 
 */

namespace Mvc;


use stdClass;

class Store
{
    /**
     * @var stdClass
     */
    private $store;

    public function __construct()
    {
        $this->store = new stdClass();
    }

    /**
     * @param string $name
     * @return null|mixed
     */
    public function __get($name)
    {
        if (!property_exists($this->store, $name)) {
            return null;
        }
        return $this->store->$name;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return \Mvc\Store
     */
    public function __set($name, $value)
    {
        if (property_exists($this->store, $name)) {
            error_log( 'Entry ' .  $name . ' will be overwritten');
        }
        $this->store->$name = $value;
        return $this;
    }

}