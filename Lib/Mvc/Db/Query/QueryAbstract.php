<?php
/**
 * abstract class for all queries
 *
 * PHP version >=5.3
 *
 * @category Query
 * @package  Mvc\Db
 * @author   dknx01 <e.wiitahuer@gmail.com>
 */

namespace Mvc\Db;

class Query_QueryAbstract
{

    /**
     * the table instance
     * @var \Mvc\Db\Table
     */
    protected $table = null;

    /**
     * constructor
     *
     * @param \Mvc\Db\Table $table the Table definition
     *
     * @return void
     */
    function __construct(\Mvc\Db\Table $table)
    {
        $this->table = $table;
    }

}

