<?php
/**
 * the config parser
 * 
 * PHP version >=5.3
 * 
 * @package Mvc\Config
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Config;
use Exception;
use \Mvc\Config\Definition;

class ParseConfig
{
    /**
     * configuration file name
     * @var string
     */
    protected $name = 'Config/Application.xml';

    /**
     * the parsed configuration data
     * @var \Mvc\Config\Definition
     */
    protected $configData = null;
    /**
     * the constructor with an optional configuration file
     * 
     * @param string $configFile
     */
    public function __construct($configFile = null)
    {
        if (!is_null($configFile)) {
            $this->name = $configFile;
        }
        $this->checkFile()->parse();
    }
    /**
     * basic checkfor the config file
     * 
     * @return \Mvc\Config\ParseConfig
     * @throws Exception
     */
    protected function checkFile()
    {
        if (!file_exists(APPDIR . '/' . $this->name)) {
            throw new Exception('Config file not found: ' . $this->name);
        }
        if (substr($this->name, -4) != '.xml') {
            throw new Exception('Config file must be xml.');
        }
        return $this;
    }
    /**
     * pares the config to our object
     * 
     * @return \Mvc\Config\ParseConfig
     */
    protected function parse()
    {
        $className = '\Mvc\Config\Definition\Config';
        $filename = APPDIR . '/' . $this->name;
        $this->configData = simplexml_load_file($filename, $className);
        return $this;
    }
    /**
     * get the parsed configuration datas
     * 
     * @return \Mvc\Config\Definition\Config
     */
    public function getConfigData()
    {
        return $this->configData;
    }
}
