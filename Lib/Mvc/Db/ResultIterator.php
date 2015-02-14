<?php
/**
 * an iterator to iterate over all recived columns
 * 
 * PHP version >=5.3
 * 
 * 
 * @package Mvc\Db
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Db;
use \Iterator;

class ResultIterator implements Iterator
{
    /**
     * the position
     * @var int
     */
    private $position = 0;
    /**
     * the rows
     * @var array
     */
    private $items = array();
    /**
     * the constructor
     * 
     * @param array $results
     */
    public function __construct(array $results)
    {
        $this->position = 0;
        $this->items = $results;
    }
    /**
     * reset the pointer to the first element
     */
    function rewind()
    {
        $this->position = 0;
    }
    /**
     * get the current row model
     * 
     * @return \Mvc\Db\Model
     */
    function current()
    {
        return $this->items[$this->position];
    }
    /**
     * get the current position
     * 
     * @return int
     */
    function key()
    {
        return $this->position;
    }
    /**
     * increase the pointer
     */
    function next()
    {
        ++$this->position;
    }
    /**
     * check if the current position exists
     * 
     * @return boolean
     */
    function valid()
    {
        return array_key_exists($this->position, $this->items);
    }
}
