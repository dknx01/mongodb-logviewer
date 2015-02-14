<?php
/**
 * Created by JetBrains PhpStorm.
 * User: erik
 * Date: 25.06.13
 * Time: 21:13
 * To change this template use File | Settings | File Templates.
 */

namespace Mvc\Db\MongoDb;

use \MongoClient as Mongo;
use \Mvc\Config as Config;

class Adapter extends Mongo
{
    protected $host = Mongo::DEFAULT_HOST;
    protected $port = Mongo::DEFAULT_PORT;
    protected $user = '';
    protected $password = '';
    protected $dbname = 'test123';
    /**
     * is the adapter active
     * @var boolean
     */
    protected $active = false;

    public function __construct()
    {
        $this->init();
        $server = 'mongodb://';
        if (!empty($this->user)) {
            $server .= $this->user . ':' . $this->password . '@';
        }
        $server .= $this->host;
        $server .= ':' . $this->port;
        if (!empty($this->dbname)) {
            $server .= '/' . $this->dbname;
        }
        parent::__construct($server);
    }

    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->dbname;
    }

    /**
     * prepare a new connection based on the configuration file
     */
    protected function init()
    {
        /**
         * @var \Mvc\Config\Definition\Config
         */
        $config = \Mvc\System::getInstance()->configuration();;
        $this->active = $config->getDatabaseStatus();
        if ($this->active == true) {
            if ($config->getDatabaseHost() != '' ) {
                $this->host = $config->getDatabaseHost();
            }
            if ($config->getDatabasePort() != '') {
                $this->port = $config->getDatabasePort();
            }
            if ($config->getDatabaseName() != '') {
                $this->dbname = $config->getDatabaseName();
            }
            $this->user = $config->getDatabaseUser();
            $this->password = $config->getDatabasePassword();
        }
    }
}