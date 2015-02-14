<?php
/**
 * interface for the service locator
 *
 * PHP version >=5.3
 *
 * @package Mvc\Di
 * @author  dknx01 <e.witthauer@gmail.com>
 */
namespace Mvc\Di;

interface ServiceLocatorInterface
{
    /**
     * registers a new service
     * 
     * @param string $name service name
     * @param onject $service service
     */
    public function set($name, $service);
    /**
     * get a service
     * 
     * @param string $name service name
     */
    public function get($name);
    /**
     * checks if a service is already registered
     * 
     * @param string $name service name
     */
    public function has($name);
    /**
     * removes a registered service from the locator
     * 
     * @param string $name service name
     */
    public function remove($name);
    /**
     * removes all registered services from the locator
     */
    public function clear();
    /**
     * returns all registered services
     */
    public function index();
    /**
     * checks if a service is registered
     * @param string $name service name
     */
    public function serviceExists($name);
}