<?php
/**
 * Created by JetBrains PhpStorm.
 * User: erik
 * Date: 26.06.13
 * Time: 21:19
 * To change this template use File | Settings | File Templates.
 */

namespace Mvc\Db\MongoDb;


class Mapper
{
    protected $mapper = array('objectId' => '_id');

    protected $primary = '';

    /**
     * @param string $primary
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;
    }

    /**
     * @return string
     */
    public function getPrimary()
    {
        return $this->primary;
    }

    /**
     * @param array $mapper
     * @return Mvc\Db\MongoDb\Mapper
     */
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * @return array
     */
    public function getMapper()
    {
        return $this->mapper;
    }

}