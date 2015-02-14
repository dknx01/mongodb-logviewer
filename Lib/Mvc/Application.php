<?php
/**
 * the main class for all the mvc application
 *
 * PHP version >= 5.3
 *
 *
 *
 * @package Mvc
 * @author  dknx01 <e.witthauer@gmail.com>
 * @license https://github.com/dknx01/micromvc/blob/master/license.txt BSD License
 *
 */
namespace Mvc;

use \Mvc\Config as Config;
use \Mvc\Db as Db;
use \Mvc\View as View;
use \Mvc\System as System;
use \Exception;
use PDOException;

/**
 * the application class to run it all
 */
class Application
{
    /**
     * request handler
     * @var \Mvc\Helper\Request
     */
    protected $request = null;
    /**
     * name of the controller
     * @var string
     */
    protected $controller = '';
    /**
     * name of the action method
     * @var string
     */
    protected $action = '';
    /**
     * the loaded and parsed config file
     * @var \Mvc\Config\Definition\Config
     */
    protected $config = null;
    /**
     * an instance of the view output
     * @var \Mvc\View\Output
     */
    protected $viewOutput = null;

    /**
     * @var string
     */
    private $cssRoot;

    /**
     * @var string
     */
    private $jsRoot;

    /**
     * @var \Mvc\View\ConfigData
     */
    private $viewConfigData;

    /**
     * prepare the application
     */
    public function __construct()
    {
        $this->request = System::getInstance()->getRequest();
        $this->viewOutput = new View\Output($this->getRequest());
        $this->startUp();
    }
    /**
     * run the application
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        try {
            $controllerName = $this->getController();
            /**
             * @var \Mvc\Controller\ControllerAbstract
             */
            $controller = new $controllerName();
            $actionMethod = $this->getAction();
            $controller->$actionMethod();
            $this->proccessOutput($controller);
            $this->shutDown();
        } catch (Exception $e) {
            throw new Exception($e->getMessage() . PHP_EOL . $e->getTraceAsString() . PHP_EOL);
        }

    }
    /**
     * return the request object
     *
     * @return \Mvc\Helper\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    /**
     * set the request objec
     *
     * @param \Mvc\Helper\Request $request
     * @return \Mvc\Application
     */
    public function setRequest(\Mvc\Helper\Request $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * return the current controller name
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * set the controller name
     * @param string $_controller
     * @return \Mvc\Application
     */
    public function setController($_controller)
    {
        $this->controller = 'Application\Controller\\' . $_controller;
        return $this;
    }
    /**
     * prepare the database connection and store them in the registry
     *
     * @return \Mvc\Application
     * @throws \Exception
     */
    protected function prepareDatabase()
    {
        if ($this->config->getDatabaseStatus() == true) {
                try {
                    if (strtolower($this->config->getDatabaseType()) == 'mongodb') {
                        $db = new Db\MongoDb\Adapter();
                    } else {
                        $db = new Db\Adapter();
                    }
                    System::getInstance()->database($db);
                    System::getInstance()->serviceLocator()->set('db', $db);
                } catch (PDOException $exc) {
                    throw new Exception($exc->getMessage() . PHP_EOL . $exc->getTraceAsString());
                }
        }
        return $this;
    }
    /**
     * the current action
     *
     * @return string the action method name
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * set the action method name
     *
     * @param string $action
     * @return \Mvc\Application
     */
    public function setAction($action)
    {
        $this->action = $action . 'Action';
        return $this;
    }
    /**
     * proccess and render the output
     *
     * @param \Mvc\Controller\ControllerAbstract $controller
     */
    protected function proccessOutput(\Mvc\Controller\ControllerAbstract $controller)
    {
        $viewNameController = $controller->getViewName();
        $this->viewOutput->setViewData($controller->getViewData())
                   ->setConfig($this->config)
                   ->setLayout($controller->getLayout())
                    ->setContentHeader($controller->getContentHeader())
                   ->isAjax($controller->isAjax());
        if (!empty($viewNameController)) {
            $this->viewOutput->setView($viewNameController);
        }
        if (\Mvc\System::getInstance()->get('isCli') == true) {
            $viewName = substr($this->viewOutput->getView(),0 , -5) . 'cli.phtml';
            $viewHeader = substr($this->viewOutput->getHeader(),0 , -5) . 'cli.phtml';
            $viewFooter = substr($this->viewOutput->getFooter(),0 , -5) . 'cli.phtml';
            if (file_exists($viewName)) {
                $this->viewOutput->setView($viewName);
            }
            if (file_exists($viewHeader)) {
                $this->viewOutput->setHeader($viewHeader);
            }
            if (file_exists($viewFooter)) {
                $this->viewOutput->setFooter($viewFooter);
            }
        }
        $this->viewOutput->renderComplete();
    }
    /**
     * the shutdown function for everything at the end
     */
    protected function shutDown()
    {
        if (!is_null(System::getInstance()->database())) {
            System::getInstance()->set('database', null);
        }
    }
    /**
     * additional work before the rendering
     *
     * @throws \Exception
     */
    protected function startUp()
    {
        if (file_exists(APPDIR . '/Config/Bootstrap.php')) {
            try {
                include_once APPDIR . '/Config/Bootstrap.php';
            } catch (Exception $exc) {
                throw new Exception($exc->getMessage() . PHP_EOL . $exc->getTraceAsString());
            }
        }
        $config = new Config\ParseConfig();
        $this->config = $config->getConfigData();
        System::getInstance()->configuration($this->config);
        $this->viewConfigData = new View\ConfigData();

        $this->setController($this->getRequest()->getControllerName())
            ->setAction($this->getRequest()->getAction())
            ->prepareDatabase();
        $this->viewConfigData->addJavascriptFilesFromConfig();
        $this->viewConfigData->addCssFilesFromConfig();
        $this->viewConfigData->addExternalDataToView();
    }
}
