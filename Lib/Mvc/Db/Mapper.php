<?php
/**
 * the basic mapper class
 * 
 * PHP version >=5.3
 * 
 * @package Mvc\Db
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Db;

class Mapper
{
    /**
     * the model db result mapper
     * @var array
     */
    protected $mapper = array();
    /**
     * the primary key column
     * @var string
     */
    protected $primary = '';
    /**
     * get the primary key column
     * @return string
     */
    public function getPrimary()
    {
        return $this->primary;
    }
    /**
     * set the primary key column
     * 
     * @param string $primary
     * 
     * @return \Mvc\Db\Mapper
     */
    public function setPrimary($primary)
    {
        $this->primary = (string)$primary;
        return $this;
    }
    /**
     * get the mapper
     * 
     * @return array
     */
    public function getMapper()
    {
        return $this->mapper;
    }
    /**
     * set a mapper
     * 
     * @param array $mapper
     * 
     * @return \Mvc\Db\Mapper
     */
    public function setMapper(array $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }
}
