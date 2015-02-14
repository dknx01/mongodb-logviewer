<?php
/**
 * the registry object to store datas
 *
 * PHP version >= 5.3
 *
 * @author  dknx01 <e.witthauer@gmail.com>
 * @package Mvc\Registry
 */

namespace Mvc;
use \stdClass;

class Registry
{
    /**
     * our store
     * @var \stdClass
     */
    protected $store = null;
    /**
     * the current instance
     * @var \Mvc\Registry|null
     */
    static private $instance = null;

    /**
     * get the current registry or create a new one
     * @return \Mvc\Registry
     */
    static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     * the constructor
     */
    public function __construct()
    {
        $this->store = new stdClass();
    }

    /**
     * gets a value from our store
     * @param string $name
     * @throws Exception
     * @return null|mixed
     */
    public function get($name)
    {
        if (property_exists($this->store, $name)) {
            return $this->store->$name;
        } else {
            return null;
        }
    }

    /**
     * set a new entry in the store
     * @param string $name
     * @param mixed $value
     * @return \Mvc\Registry
     */
    public function set($name, $value)
    {
        if (property_exists($this, $name)) {
           error_log( 'Entry ' .  $name . ' will be overwritten');
        }
        $this->store->$name = $value;
        return $this;
    }
}
