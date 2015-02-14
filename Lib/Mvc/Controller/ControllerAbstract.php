<?php
/**
 * the abstract controller class
 * 
 * PHP version >=5.3
 * 
 * @package Mvc\Controller
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Controller;
use \Mvc\System as System;
use \stdClass;

abstract class ControllerAbstract
{
    /**
     * the view data
     * @var \stdClass
     */
    protected $viewData = null;
    /**
     * the request object
     * @var \Mvc\Helper\Request
     */
    protected $request = null;
    /**
     * the view name
     * @var string
     */
    protected $viewName = '';
    /**
     * is it an ajax view
     * @var boolean
     */
    protected $isAjax = false;
    /**
     * the layout name
     * @var string|null
     */
    protected $layout = null;

    /**
     * @var string|null
     */
    protected $contentHeader = null;

    /**
     * the service locator
     * @var \Mvc\Di\ServiceLocator
     */
    protected $serviceLocator = null;
    /**
     * the constructor
     */
    public function __construct()
    {
        $this->viewData = new stdClass();
        $this->request = System::getInstance()->getRequest();
        $this->run();
    }

    /**
     * function to run the controllers and maybe do some preparing
     */
    public function run()
    {
        $this->up();
    }
    /**
     * setup the current controller
     */
    protected function up()
    {
    }
    /**
     * the main function
     */
    abstract function indexAction();
    /**
     * adds an entry to the view
     * 
     * @param string $name
     * @param mixed $value
     * 
     * @return \Mvc\Controller\ControllerAbstract
     */
    public function addToView($name, $value)
    {
        $this->viewData->$name = $value;
        return $this;
    }
    /**
     * get the request helper object
     * 
     * @return \Mvc\Helper\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    /**
     * check if this is an ajax view request
     * 
     * @return boolean
     */
    public function isAjax()
    {
        return $this->isAjax;
    }
    /**
     * set if this is an ajax view request
     * 
     * @param boolean $_isAjax
     * 
     * @return \Mvc\Controller\ControllerAbstract
     */
    public function setIsAjax($_isAjax)
    {
        $this->isAjax = $_isAjax;
        return $this;
    }
    /**
     * get the view name for the controller
     * 
     * @return string
     */
    public function getViewName()
    {
        return $this->viewName;
    }
    /**
     * set the controllers view name
     * 
     * @param string $_viewName
     * 
     * @return \Mvc\Controller\ControllerAbstract
     */
    public function setViewName($_viewName)
    {
        $this->viewName = $_viewName;
        return $this;
    }
    /**
     * get all data used in the view
     * 
     * @return stdClass
     */
    public function getViewData()
    {
        return $this->viewData;
    }
    /**
     * the layout name
     * 
     * @return string|null
     */
    public function getLayout()
    {
        return $this->layout;
    }
    /**
     * set a new layout name
     * 
     * @param string $layout
     * 
     * @return \Mvc\Controller\ControllerAbstract
     */
    public function setLayout($layout)
    {
        $this->layout = empty($layout) ? null : $layout;
        return $this;
    }
    /**
     * get or set a new service locator
     * 
     * @param \Mvc\Di\ServiceLocator $serviceLocator the new service locator
     * 
     * @return \Mvc\Di\ServiceLocator
     */
    public function serviceLocator(\Mvc\Di\ServiceLocator $serviceLocator = null)
    {
        if (!is_null($serviceLocator)) {
            $this->serviceLocator = $serviceLocator;
        } elseif (is_null($this->serviceLocator)) {
            $this->serviceLocator = System::getInstance()->serviceLocator();
        }
        return $this->serviceLocator;
    }

    /**
     * @return null|string
     */
    public function getContentHeader()
    {
        return $this->contentHeader;
    }

    /**
     * @param null|string $contentHeader
     *
     * @return \Mvc\Controller\ControllerAbstract
     */
    public function setContentHeader($contentHeader)
    {
        $this->contentHeader = $contentHeader;
        return $this;
    }

}
