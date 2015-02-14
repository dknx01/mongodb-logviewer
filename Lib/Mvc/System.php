<?php
/**
 * class for system object calls
 *
 * PHP version >=5.3
 *
 * @package Mvc
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc;

use Exception;
use Mvc\Store;

class System
{
    /**
     * our store
     * @var Store
     */
    protected $store = null;

    /**
     * the instances of called objects
     * @var array
     */
    static private $instance = null;

    /**
     * get the current registry or create a new one
     * @return \Mvc\System
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
        $this->store = new Store();
    }

    /**
     * gets a value from our store
     * @param string $name
     * @throws Exception
     * @return null|mixed
     */
    public function get($name)
    {
        return $this->store->$name;
    }

    /**
     * set a new entry in the store
     * @param string $name
     * @param mixed $value
     * @return \Mvc\System
     */
    public function set($name, $value)
    {
        $this->store->$name = $value;
        return $this;
    }

    /**
     * set or get the view header data
     * 
     * @param string $data the view data or null
     * 
     * @return string
     */
    public function viewHeader($data = null)
    {
        if (!is_null($data)) {
            $this->store->viewHeader = $data;
        }
        return $this->store->viewHeader;
    }

    /**
     * set or get the view footer data
     * 
     * @param string $data the view data or null
     * 
     * @return string
     */
    public function viewFooter($data = null)
    {
        if (!is_null($data)) {
            $this->store->viewFooter = $data;
        }
        return $this->store->viewFooter;
    }

    /**
     * set or get the view content data
     * 
     * @param string $data the view data or null
     * 
     * @return string
     */
    public function viewContent($data = null)
    {
        if (!is_null($data)) {
            $this->store->viewContent = $data;
        }
        return $this->store->viewContent;
    }

    /**
     * set or get the view doctype data
     * 
     * @param string $data the view data or null
     * 
     * @return string
     */
    public function viewDoctype($data = null)
    {
        if (!is_null($data)) {
            $this->store->viewDoctype = $data;
        }
        return $this->store->viewDoctype;
    }

    /**
     * get the request object
     * 
     * @return \Mvc\Helper\Request
     */
    public function getRequest()
    {
        if (is_null($this->store->request)) {
            if (PHP_SAPI == 'cli') {
                $this->store->request = new \Mvc\Cli\CliRequest($this->store->cliArgs);
            } else {
                $this->store->request = new \Mvc\Helper\Request();
            }
        }
        return $this->store->request;
    }
    /**
     * get or set the database adapter
     * 
     * @param \Mvc\Db\Adapter|\Mvc\Db\MongoDb\Adapter $data a new database connection or null
     * 
     * @return \Mvc\Db\Adapter|\Mvc\Db\MongoDb\Adapter
     */
    public function database($data = null)
    {
        if (!is_null($data)) {
            $this->store->database = $data;
        }
        return $this->store->database;
    }

    /**
     * get or set a service locator
     * 
     * @param \Mvc\Di\ServiceLocator $locator a new service locator
     * 
     * @return \Mvc\Di\ServiceLocator
     */
    public function serviceLocator(\Mvc\Di\ServiceLocator $locator = null)
    {
        if (!is_null($locator)) {
            $this->store->serviceLocator = $locator;
        } elseif (is_null($this->store->serviceLocator)) {
            $this->store->serviceLocator = new \Mvc\Di\ServiceLocator();
        }
        return $this->store->serviceLocator;
    }

    /**
     * get or set a config object
     * @param Config\Definition\Config $config
     *
     * @return Config\Definition\Config
     */
    public function configuration(\Mvc\Config\Definition\Config $config = null)
    {
        if (!is_null($config)) {
            $this->store->configuration = $config;
        } elseif (is_null($this->store->configuration)) {
            $config = new \Mvc\Config\ParseConfig();
            $this->store->configuration = $config->getConfigData();
        }
        return $this->store->configuration;
    }

    /**
     * set or get the view navi data
     *
     * @param string $data the view data or null
     *
     * @return string
     */
    public function viewNavi($data = null)
    {
        if (!is_null($data)) {
            $this->store->viewNavi = $data;
        }
        return $this->store->viewNavi;
    }

    /**
     * set or get the view content header data (on all pages but under the navi)
     *
     * @param string $data the view data or null
     *
     * @return string
     */
    public function viewContentHeader($data = null)
    {
        if (!is_null($data)) {
            $this->store->viewContentHeader = $data;
        }
        return $this->store->viewContentHeader;
    }

}