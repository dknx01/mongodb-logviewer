<?php
/**
 * procces the output passed to the browser
 *
 * PHP version >=5.3
 *
 * @package Mvc\View
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\View;
use Exception;
use \stdClass;
use \Mvc\Config\Definition\Config as ConfigDefinition;
use \Mvc\Helper\Request as Request;
use \Mvc\System as System;
use \Mvc\View\DocTypes as Doctypes;

Class Output
{
    /**
     * the layout file name
     * @var string
     */
    private $layout = 'Layout';
    /**
     * the header file name
     * @var string
     */
    private $header = null;
    /**
     * the view file name
     * @var string
     */
    private $view = 'Index';
    /**
     * the footer file name
     * @var string
     */
    private $footer = null;
    /**
     * the request object
     * @var \Mvc\Helper\Request
     */
    private $request = null;
    /**
     * the data passed to the view
     * @var \stdClass
     */
    private $viewData = null;
    /**
     * is this an ajax file
     * @var boolean
     */
    private $ajax = false;
    /**
     * the loaded and parsed configuration
     * @var \Mvc\Config\Definition\Config
     */
    protected $config = null;
    /**
     * the doctype of the site
     * @var string
     */
    protected $doctype = \Mvc\View\DocTypes::HTML5;

    /**
     * @var string
     */
    private $contentHeader;

    /**
     * the constructor
     *
     * @param \Mvc\Helper\Request $request
     */
    public function __construct(Request $request)
    {
        $this->viewData = new stdClass();
        $this->setRequest($request);
        $this->setView()
             ->setHeader()
             ->setFooter()
            ->setContentHeader();
    }
    /**
     * the complete output
     */
    public function renderComplete()
    {
        $doctypeFunction = method_exists('\Mvc\View\DocTypes', $this->getDoctype())
                           ? $this->getDoctype()
                           : Doctypes::HTML5;
        System::getInstance()->viewDoctype(Doctypes::$doctypeFunction());

        ob_start();
        include_once $this->getView();
        $viewOutput = ob_get_contents();
        ob_end_clean();
        System::getInstance()->viewContent($viewOutput);

        if (file_exists($this->getHeader())) {
            ob_start();
            include_once $this->getHeader();
            $viewOutputHeader = ob_get_contents();
            ob_end_clean();
            System::getInstance()->viewHeader($viewOutputHeader);
        }

        if (file_exists($this->getNavi())) {
            ob_start();
            include_once $this->getNavi();
            $viewOutputNavi = ob_get_contents();
            ob_end_clean();
            System::getInstance()->viewNavi($viewOutputNavi);
        }

        if (file_exists($this->getContentHeader())) {
            ob_start();
            include_once $this->getContentHeader();
            $viewOutputContentHeader = ob_get_contents();
            ob_end_clean();
            System::getInstance()->viewContentHeader($viewOutputContentHeader);
        }

        if (file_exists($this->getFooter())) {
            ob_start();
            include_once $this->getFooter();
            $viewOutputFooter = ob_get_contents();
            ob_end_clean();
            System::getInstance()->viewFooter($viewOutputFooter);
        }

        if (\Mvc\System::getInstance()->get('isCli') == true
            && file_exists(APPDIR . '/Layout/Cli.phtml')
        ) {
            include_once APPDIR . '/Layout/Cli.phtml';
        } elseif ($this->isAjax() == false) {
            include_once $this->getLayout();
        } else {
            include_once APPDIR . '/Layout/Ajax.phtml';

        }
    }
    /**
     *  get the current layout
     *
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }
    /**
     * set a new layout
     *
     * @param string $layout
     * @return \Mvc\View\Output
     */
    public function setLayout($layout = null)
    {
        $layout = is_null($layout) ? 'Layout' : $layout;
        $this->layout = APPDIR . '/Layout/' . $layout . '.phtml';
        return $this;
    }
    /**
     * get the current header
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }
    /**
     * set a new header
     *
     * @param string $header
     * @return \Mvc\View\Output
     */
    public function setHeader($header = null)
    {
        $header = is_null($header)
                  ? $this->getRequest()->getControllerName() . '/' . ucfirst($this->getRequest()->getAction())
                  : $header;
        $this->header = APPDIR . '/View/' . $header . '.header.phtml';
        return $this;
    }
    /**
     * get the current view
     *
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }
    /**
     * set a new view
     *
     * @param string $view
     * @return \Mvc\View\Output
     */
    public function setView($view = null)
    {
        $view = is_null($view)
                ? $this->getRequest()->getControllerName() . '/' . ucfirst($this->getRequest()->getAction())
                : $view;
        $this->view = APPDIR . '/View/' . $view . '.phtml';
        return $this;
    }
    /**
     * get the current footer
     *
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }
    /**
     * set a new footer
     *
     * @param string $footer
     * @return \Mvc\View\Output
     */
    public function setFooter($footer = null)
    {
        $footer = is_null($footer) 
                  ? $this->getRequest()->getControllerName() . '/' . ucfirst($this->getRequest()->getAction())
                  : $footer;
        $this->footer = APPDIR . '/View/' . $footer . '.footer.phtml';
        return $this;
    }
    /**
     * get the current content header
     *
     * @return string
     */
    public function getContentHeader()
    {
        return $this->contentHeader;
    }
    /**
     * set a new footer
     *
     * @param string $contentHeader
     * @return \Mvc\View\Output
     */
    public function setContentHeader($contentHeader = null)
    {
        $contentHeader = is_null($contentHeader)
                  ? $this->getRequest()->getControllerName() . '/' . ucfirst($this->getRequest()->getAction())
                  : $contentHeader;
        $this->contentHeader = APPDIR . '/View/' . $contentHeader . '.header.phtml';
        return $this;
    }
    /**
     * get the request object
     *
     * @return \Mvc\Helper\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    /**
     * set a new request object
     *
     * @param \Mvc\Helper\Request $request
     * @return \Mvc\View\Output
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
        return $this;
    }
    /**
     * set new view data object
     *
     * @param stdClass $viewData
     * @return \Mvc\View\Output
     */
    public function setViewData(stdClass $viewData)
    {
        $this->viewData = $viewData;
        return $this;
    }
    /**
     * get or set if it is an ajax view
     *
     * @param boolean|null $ajax
     * @return boolean
     */
    public function isAjax($ajax = null)
    {
        if (!is_null($ajax)) {
            $this->ajax = (boolean)$ajax;
        }
        return $this->ajax;
    }
    /**
     *  get the configuration object
     *
     * @return \Mvc\Config\Definition\Config
     */
    public function getConfig()
    {
        return $this->config;
    }
    /**
     * set the configuration object
     *
     * @param \Mvc\Config\Definition\Config $config
     * @return \Mvc\View\Output
     */
    public function setConfig(ConfigDefinition $config)
    {
        $this->config = $config;
        return $this;
    }
    /**
     * returns the value for the key of the view data or null if it's not exists.
     * If no key is provided the whole view data stor will be returned.
     *
     * @param string $key
     * @return null|mixed
     */
    public function getViewData($key = null)
    {
        if (is_null($key)) {
            return $this->viewData;
        } elseif (property_exists($this->viewData, $key)) {
            return $this->viewData->$key;
        } else {
            return null;
        }
    }
    /**
     * adds an entry to the view data object
     *
     * @param string $name
     * @param mixed $value
     *
     * @return \Mvc\Controller\ControllerAbstract
     */
    public function addToViewData($name, $value)
    {
        $this->viewData->$name = $value;
        return $this;
    }
    /**
     * returns the doctype
     *
     * @return string
     */
    public function getDoctype()
    {
        return $this->doctype;
    }
    /**
     * set the doctype of the site
     *
     * @param string $doctype
     * @return \Mvc\View\Output
     */
    public function setDoctype($doctype)
    {
        $this->doctype = $doctype;
        return $this;
    }

    /**
     * renders a view scripts
     *
     * @param $path string the script path started from APPDIR
     */
    public function render($path)
    {
        $return = '';
        ob_start();
        include_once APPDIR . '/' . $path;
        $return = ob_get_contents();
        ob_end_clean();
        echo $return;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->getViewData($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->addToViewData($name, $value);
    }

    /**
     * @param string $filename
     * @return string
     */
    public function getContent($filename)
    {

        if (!file_exists($filename)) {
            if (file_exists(APPDIR . '/View/' . $filename . '.phtml')) {
                $filename = APPDIR . '/View/' . $filename . '.phtml';
            } else {
                throw new Exception('File not found: ' . $filename);
            }
        }
        ob_start();
        include_once $filename;
        $viewOutput = ob_get_contents();
        ob_end_clean();
        return $viewOutput;
    }

    /**
     * @return string
     */
    protected function getNavi()
    {
        return APPDIR . '/Layout/Navi.phtml';
    }
}
