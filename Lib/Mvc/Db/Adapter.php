<?php
/**
 * the adapter for our database connection
 * 
 * PHP version >=5.3
 * 
 * @package Mvc\Db
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Db;
use \PDO as PDO;
use \Mvc\Config as Config;

class Adapter extends PDO
{
    /**
     * the generated dsn
     * @var string
     */
    protected $dsn = '';
    /**
     * the database connection parameters
     * @var array
     */
    protected $params = array();

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var boolean
     */
    private $active;

    /**
     * the constructor
     */
    public function __construct()
    {
        $this->init();
        if ($this->active == true) {
            parent::__construct($this->dsn, $this->user, $this->password);
            $this->proccedParams();
        }
    }
    /**
     * procces all parameters
     */
    protected function proccedParams()
    {
        foreach ($this->params as $key => $value) {
            $stmt =  $stmt = 'SET ' . $this->quote($key) . ' '
                                . $this->quote($value);
            $this->exec($stmt);
        }
    }
    /**
     * prepare a new connection based on the configuration file
     */
    protected function init()
    {
        $configParser = new Config\ParseConfig();
        /**
         * @var \Mvc\Config\Definition\Config
         */
        $config = $configParser->getConfigData();
        $this->active = $config->getDatabaseStatus();
        if ($this->active == true) {
            $this->params = $config->getDatabaseParams();
            if ($config->getDatabaseType() == 'sqlite') {
                $this->dsn = 'sqlite:' . $config->getDatabasePath();
            } else {
                $this->dsn = $config->getDatabaseType()
                    . ':host=' . $config->getDatabaseHost() . ';'
                    . 'dbname=' . $config->getDatabaseName();
                $this->user = $config->getDatabaseUser();
                $this->password = $config->getDatabasePassword();
                $this->params = $config->getDatabaseParams();
            }
        }
    }
}
