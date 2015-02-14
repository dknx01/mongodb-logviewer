<?php

namespace Mvc\Cli;

use \Mvc\Helper\Request as Request;

class CliRequest extends Request
{
    protected $cliArgs = null;
//    public function __construct($args)
//    {
//        $this->cliArgs = $args;
//        $this->
//    }
    
    /**
     * the constructor
     */
    public function __construct($args)
    {
        $this->cliArgs = $args;
        if (count($this->queryString) > 0) {
            $this->checkController()
                 ->checkAction()
                 ->checkParams();
        }
    }
    
    private function checkController()
    {
        if (array_key_exists('c', $this->cliArgs)
            && !empty($this->cliArgs['c'])
        ) {
            $this->setControllerName($this->cliArgs['c']);
        } elseif (array_key_exists('controller', $this->cliArgs)
                && !empty ($this->cliArgs['controller'])
        ) {
            $this->setControllerName($this->cliArgs['controller']);
        }
        return $this;
    }
    private function checkAction()
    {
        if (array_key_exists('a', $this->cliArgs)
            && !empty($this->cliArgs['a'])
        ) {
            $this->setAction($this->cliArgs['a']);
        } elseif (array_key_exists('action', $this->cliArgs)
                && !empty ($this->cliArgs['action'])
        ) {
            $this->setAction($this->cliArgs['action']);
        }
        return $this;
    }
    private function checkParams()
    {
        if (array_key_exists('q', $this->cliArgs)) {
            $this->queryString = $this->cliArgs['q'];
        }
        if (array_key_exists('query', $this->cliArgs)) {
            if (strlen($this->queryString) > 0)
            {
                $this->queryString .= '&' . $this->cliArgs['query'];
            } else {
                $this->queryString = $this->cliArgs['query'];
            }
        }
        $this->getAllParams(false, false);
        return $this;
    }
}