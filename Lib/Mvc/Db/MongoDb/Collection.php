<?php
/**
 * Created by JetBrains PhpStorm.
 * User: erik
 * Date: 26.06.13
 * Time: 20:58
 * To change this template use File | Settings | File Templates.
 */

namespace Mvc\Db\MongoDb;

use Exception;
use MongoClient;
use MongoCollection;
use MongoCursor;
use Mvc\Db\MongoDb\Adapter;

abstract class Collection {

    /* collection name
    * @var string
    */
    protected $name = '';

    /**
     * @var Adapter|MongoClient
     */
    private $connection;

    /**
     * the constructor
     *
     * @throws Exception
     */
    public function __construct(\Mvc\Di\ServiceLocator $sl)
    {
        $this->connection = $sl->get('db');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return MongoCollection
     */
    public function getConnection()
    {
        return $this->connection->selectCollection($this->connection->getDbName(), $this->getName());
    }

    /**
     * @return MongoCursor
     */
    public function findAll()
    {
        return $this->connection->selectCollection($this->connection->getDbName(), $this->getName())->find();
    }

    /**
     * @param string $column
     * @param string $value
     * @return MongoCursor
     */
    public function findAllByColumnValue($column, $value)
    {
        return $this->getConnection()->find(array($column => $value))->sort(array('_id' => -1));
    }
}