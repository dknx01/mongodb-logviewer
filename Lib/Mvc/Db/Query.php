<?php

/**
 * the query class
 *
 * PHP version >=5.3
 *
 * @category Query
 * @package  Mvc\Db
 * @author   dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Db;

use \Mvc\Db\ResultIterator as ResultIterator;
use \Mvc\Db as Db;
use \PDOException;
use \Exception;

class Query
{

    /**
     * the table definition
     * @var \Mvc\Db\Table
     */
    protected $table;

    /**
     * constructor
     *
     * @param \Mvc\Db\Table $table the table
     *
     * @return void
     */
    public function __construct(\Mvc\Db\Table $table)
    {
        $this->table = $table;
    }

    /**
     * a SQL-SELECT query
     *
     * @return \Mvc\Db\Query_Select
     */
    public function select()
    {
        return new Db\Query_Select($this->table);
    }

}

