<?php
/**
 * helper to build a dynamic sql select query
 *
 * PHP version >=5.3
 * 
 * @category Query
 * @package  Mvc\Db
 * @author   dknx01 <e.wiitahuer@gmail.com>
 */

namespace Mvc\Db;

use \Mvc\Db\ResultIterator as ResultIterator;
use \PDOException;
use \Exception;

/**
 * select builder class
 */
class Query_Select extends \Mvc\Db\Query_QueryAbstract
{

    /**
     * the selected columns
     * @var array
     */
    private $selectColumns = array();

    /**
     * the WHERE conditions
     * @var array
     */
    private $where = array();

    /**
     * the LIMIT condition
     * @var string
     */
    private $limit = '';

    /**
     * the ORDER BY conditions
     * @var array
     */
    private $orderBy = array();

    /**
     * the GROUP BY conditions
     * @var array
     */
    private $groupBy = array();

    /**
     * the HAVING condition
     * @var string
     */
    private $having = '';

    /**
     * the builded sql query
     * @var string
     */
    private $sql = '';
    /**
     * build the sql query. mostly used for debug
     *
     * @return string
     */
    public function build()
    {
        $this->buildQuery();
        return $this->sql;
    }

    /**
     * build and run the sql query
     *
     * @return \Mvc\Db\ResultIterator
     *
     * @throws \Exception
     */
    public function query()
    {
        $this->buildQuery();
        $result = array();
        try {
            foreach ($this->table->getConnection()->query($this->sql) as $row) {
                $result[] = $this->table->mapper($row);
            }
        } catch (\PDOException $exc) {
            throw new \Exception($exc->getMessage() . PHP_EOL . $exc->getTraceAsString());
        }
        return new ResultIterator($result);
    }

    /**
     * the selected columns
     *
     * @return array
     */
    public function getSelectColumns()
    {
        return $this->selectColumns;
    }

    /**
     * add a new select column definition
     *
     * @param string $name column definition
     *
     * @return \Mvc\Db\Query_Select
     */
    public function column($name)
    {
        $this->selectColumns[] = $name;
        return $this;
    }

    /**
     * the where conditions
     *
     * @return array
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * add a new WHERE condition
     *
     * @param string $where the where condition
     *
     * @return \Mvc\Db\Query_Select
     */
    public function where($where)
    {
        $this->where[] = $where;
        return $this;
    }

    /**
     * the limit condition
     *
     * @return string
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * set the LIMIT condition
     *
     * @param string $limit the LIMIT condition
     *
     * @return \Mvc\Db\Query_Select
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * the ORDER BY conidtions
     *
     * @return array
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * add a new ORDER BY condition
     *
     * @param string $orderBy the ORDER BY condition
     *
     * @return \Mvc\Db\Query_Select
     */
    public function orderBy($orderBy)
    {
        $this->orderBy[] = $orderBy;
        return $this;
    }

    /**
     * the GROUP BY conditions
     *
     * @return array
     */
    public function getGroupBy()
    {
        return $this->groupBy;
    }

    /**
     * add a new GROUP BY condition
     *
     * @param string $groupBy the condition
     *
     * @return \Mvc\Db\Query_Select
     */

    public function groupBy($groupBy)
    {
        $this->groupBy[] = $groupBy;
        return $this;
    }

    /**
     * the HAVING condition
     *
     * @return string
     */
    public function getHaving()
    {
        return $this->having;
    }

    /**
     * set the HAVING condition
     *
     * @param string $having the condition
     *
     * @return \Mvc\Db\Query_Select
     */
    public function having($having)
    {
        $this->having = $having;
        return $this;
    }

    /**
     * build the SQL-query string
     *
     * @return void
     */
    protected function buildQuery()
    {
        $sql = '';
        $sql = 'SELECT';
        if (count($this->getSelectColumns()) > 0) {
            $sql .= $this->proccessParts($this->getSelectColumns());
        } else {
            $sql .= ' * ';
        }
        $sql .= 'FROM `' . $this->table->getName() . '`';
        if (count($this->getWhere()) > 0) {
            $sql .= ' WHERE ' . $this->proccessParts($this->getWhere());
        }
        if (count($this->getGroupBy()) > 0) {
            $sql .= ' GROUP BY ' . $this->proccessParts($this->getGroupBy());
        }
        if (!empty($this->having)) {
            $sql .= ' HAVING ' . $this->getHaving() . ' ';
        }
        if (!empty($this->orderBy)) {
            $sql .= ' GROUP BY ' . $this->proccessParts($this->getOrderBy());
        }
        if (!empty($this->limit)) {
            $sql .= ' LIMIT ' . $this->getLimit();
        }
        $this->sql = trim($sql);
    }

    /**
     * put all parts of an array conditions collection together
     *
     * @param array $entries the parts
     *
     * @return string
     */
    protected function proccessParts($entries)
    {
        $sql = ' ';
        foreach ($entries as $entry) {
            $sql .= $entry . ', ';
        }
        $sql = substr($sql, 0, -2) . ' ';
        return $sql;
    }
}

