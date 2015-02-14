<?php
/**
 * the service locator
 *
 * PHP version >=5.3
 *
 * @package Mvc\Di
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Di;

class ServiceLocator implements ServiceLocatorInterface
{
    /**
     * the registered services
     * @var array
     */
    protected $services = array();
    /**
     * register a new service
     * 
     * @param string $name service name
     * @param object $service the service object
     * 
     * @return \Mvc\Di\ServiceLocator
     * 
     * @throws \InvalidArgumentException
     */
    public function set($name, $service) {
        if (!is_object($service)) {
             throw new \InvalidArgumentException(
                "Only objects can be registered with the locator.");
        }
        if (!in_array($service, $this->services, true)) {
            $this->services[$name] = $service;
        }
        return $this;
    }
    /**
     * get a service if registered
     * 
     * @param string $name servcie name
     * 
     * @return object
     * 
     * @throws \RuntimeException
     */
    public function get($name) {
        if (!isset($this->services[$name])) {
            throw new \RuntimeException(
                'The service' . $name . 'has not been registered with the locator.');
        }
        return $this->services[$name];
    }
    /**
     * checks if a service is already registered
     * 
     * @param string $name service name
     * 
     * @return boolean
     */
    public function has($name) {
        return isset($this->services[$name]);
    }
    /**
     * removes a registered service from the locator
     * 
     * @param string $name service name
     * 
     * @return \Mvc\Di\ServiceLocator
     */
    public function remove($name) {
        if (isset($this->services[$name])) {
            unset($this->services[$name]);
        }
        return $this;
    }
    /**
     * removes all registered services from the locator
     * 
     * @return \Mvc\Di\ServiceLocator
     */
    public function clear() {
        $this->services = array();
        return $this;
    }
    /**
     * returns all registerd services
     * 
     * @return array
     */
    public function index()
    {
        return array_keys($this->services);
    }
    /**
     * checks if a service exists
     * 
     * @param string $name service name
     * 
     * @return boolean
     */
    public function serviceExists($name)
    {
        return array_key_exists($name, $this->services);
    }
}