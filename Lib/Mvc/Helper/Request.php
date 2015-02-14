<?php
/**
 * helper class to procces the request and get the basename for the controller and all params
 *
 * PHP version >=5.3
 *
 * @package Mvc\Helper
 * @author  dknx01 <e.witthauer@gmail.com>
 */
namespace Mvc\Helper;

class Request
{
    /**
     * the value separator
     * @var string
     */
    const SEPARATOR = '/';
    /**
     * the controller name
     * @var string
     */
    protected $controllerName = 'Index';
    /**
     * name of the action
     * @var string
     */
    protected $action = 'index';
    /**
     * all passed params
     * @var array
     */
    protected $params = array();
    /**
     * the query string
     * @var string
     */
    protected $queryString = '';
    /**
     * the constructor
     */
    public function __construct()
    {
        $this->queryString = '';
        if ($_SERVER['REQUEST_URI'] == '/') {
            $this->querystring = '';
        } else {
            $this->queryString = trim(substr($_SERVER['REQUEST_URI'], 1));
        }
        if (strlen($this->queryString) > 0) {
            $controllerEnd = strpos($this->queryString, self::SEPARATOR);
            if ($controllerEnd != false) {
                $this->controllerName = substr($this->queryString, 0, $controllerEnd);
                $query = substr($this->queryString, $controllerEnd + 1);
                if ($query != false) {
                    $this->queryString = $query;
                } else {
                    $this->queryString = '';
                }
                $actionEnd = strpos($this->queryString, self::SEPARATOR);
                if ($actionEnd != false) {
                    $this->action = substr($this->queryString, 0, $actionEnd);
                    $this->queryString = substr($this->queryString, $actionEnd + 1);
                    $this->getAllParams();
                } else {
                    $this->action = $this->queryString;
                    $this->originRequestUri();
                    $this->getPostParams();
                }

            } else {
                if (substr($this->queryString, 0, 1) == '?') {
                    $this->getAllParams();
                } else {
                    $this->controllerName = $this->queryString;
                    $this->originRequestUri();
                    $this->getPostParams();
                }
            }
        }
    }
    /**
     * retrive all params get by GET or POST method
     * 
     * @param boolean $withPost should POST parameters also be checked
     */
    protected function getAllParams($withPost = true, $originRequest = true)
    {
        $this->queryString = ltrim($this->queryString, '?');
        if (!empty($this->queryString)) {
            if (strpos($this->queryString, '/') != false) {
                $params = explode('/', $this->queryString);
            } else {
                $params = explode('&', $this->queryString);
            }
            foreach ($params as $param) {
                $this->splitParam($param);
            }
            if ($originRequest == true) {
                $this->originRequestUri();
            }
        }
        if ($withPost == true) {
            $this->getPostParams();
        }
    }
    /**
     * splits the param string in key and value part
     *
     * @param string $param
     * @param string $delimiter default '='
     */
    private function splitParam($param, $delimiter = '=')
    {
        $parts = explode($delimiter, $param);
        if (count($parts) == 1) {
            $this->params[$parts[0]] = '';
        } else {
            $this->params[$parts[0]] = htmlentities($parts[1]);
        }
    }

    /**
     * proccess all post params
     */
    private function getPostParams()
    {
        foreach ($_POST as $key => $value) {
            $this->params[$key] = htmlentities($value);
        }
    }
    /**
     * write the original request URI in the property queryString
     */
    private function originRequestUri()
    {
        $this->queryString = $_SERVER['REQUEST_URI'];
    }

    /**
     * the controller name
     *
     * @return string
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * set an new basename
     *
     * @param string $controllerName
     *
     * @return \Mvc\Helper\Request
     */
    public function setControllerName($controllerName)
    {
        $this->controllerName = $controllerName;
        return $this;
    }

    /**
     * all passed params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * get a param by its name
     *
     * @param string $_params
     *
     * @return string | null
     */
    public function getParamByName($name)
    {
        return (array_key_exists($name, $this->params) == true) ? $this->params[$name] : null;
    }
    /**
     * set a new param
     *
     * @param string $_name
     * @param mixed $value
     *
     * @return \Mvc\Helper\Request
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }
    /**
     * the action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
    /**
     * set a new action name
     *
     * @param string $action
     *
     * @return \Mvc\Helper\Request
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * return the value of a parameter
     *
     * @param string $name parameter name
     *
     * @return string
     */
    public function getParam($name)
    {
        return $this->getParamByName($name);
    }

}