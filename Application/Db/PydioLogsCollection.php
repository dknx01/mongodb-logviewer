<?php
/**
 * 
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 08.02.15 19:28
 * @package
 * 
 */

namespace Application\Db;


use Mvc\Db\MongoDb\Collection;

class PydioLogsCollection extends  Collection
{
    protected $name = 'pydiologs';

    /**
     * @param string $type
     * @return int
     */
    public function getEntriesNumberByType($type)
    {
        return $this->getConnection()
            ->find(array('type' => $type))
            ->count();
    }

    /**
     * @return \MongoCursor
     */
    public function getLatest()
    {
        return $this->getConnection()->find()->sort(array('_id' => -1))->limit(20);
    }

    /**
     * @return int
     */
    public function getNumberOfEntries()
    {
        return $this->getConnection()->count();
    }

    public function getAllUniqueFromColumn($column)
    {
        $keys = array($column => 1);
        $initial = array("items" => array());
        $reduce = "function ( curr, result ) { }";
        $result = $this->getConnection()->group($keys, $initial, $reduce);
        $return = $result;
        $return['retval'] = array();
        foreach ($result['retval'] as $values) {
            $return['retval'][] = $values[$column];
        }
        return $return;
    }
}