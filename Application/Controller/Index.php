<?php
/**
 * the index controller
 * @author dknx01
 * @package Application\Controller
 */
namespace Application\Controller;
use Application\Db\ApacheLogsCollection;
use Application\Db\OtherLogsCollection;
use Application\Db\PydioLogsCollection;
use Application\Db\SysLogsCollection;
use MongoClient;
use MongoCollection;
use \Mvc\Controller\ControllerAbstract;
use \Mvc\Session\Session as Session;
use \Application\Db\TestTable as TestTable;
use \Application\Form\TestForm as TestForm;
use Mvc\System;
use \Mvc\Helper\Debug;

class Index extends \Mvc\Controller\ControllerAbstract
{
    /**
     * @var PydioLogsCollection
     */
    private $pydiologs;

    /**
     * @var ApacheLogsCollection
     */
    private $apachelogs;

    /**
     * @var SysLogsCollection
     */
    private $syslogs;

    /**
     * @var OtherLogsCollection
     */
    private $otherlogs;

    /**
     * @var MongoCollection
     */
    private $types;

    protected function up()
    {
        $this->pydiologs = new PydioLogsCollection($this->serviceLocator());
        $this->apachelogs = new ApacheLogsCollection($this->serviceLocator());
        $this->syslogs = new SysLogsCollection($this->serviceLocator());
        $this->otherlogs = new OtherLogsCollection($this->serviceLocator());

        $this->addToView('types', array('apacheAccess', 'apacheError', 'Syslog', 'Pydio', 'others'));
//        $this->setContentHeader('Index/All');
    }

    /**
     * the main action with the controller logic
     */
    public function indexAction()
    {
        $this->addToView('naviActive', 'home');
        $this->addToView('accessEntriesNumber', $this->apachelogs->getEntriesNumberByType('apache_access'));
        $this->addToView('errorEntriesNumber', $this->apachelogs->getEntriesNumberByType('apache_error'));
        $this->addToView('syslogNumber', $this->syslogs->getEntriesNumberByType('syslog'));
        $this->addToView('pydioNumber', $this->pydiologs->getNumberOfEntries());
        $this->addToView('otherEntriesNumber', $this->otherlogs->getEntriesNumberByType('random_logs'));
        $this->addToView('latestEntries', $this->apachelogs->getLatest());
        $this->addToView('allEntries',
            $this->viewData->accessEntriesNumber + $this->viewData->errorEntriesNumber + $this->viewData->syslogNumber
            + $this->viewData->pydioNumber + $this->viewData->otherEntriesNumber
            );

    }

    public function findByAction()
    {
        $filterColumns = array(
            'Syslog' => array('syslog_program', 'syslog_severity'),
            'apacheAccess' => array('verb', 'httpversion', 'response', 'agent', 'request', 'clientip'),
            'apacheError' => array('clientip'),
            'Pydio' => array('ipaddress', 'timestamppydio')
        );
        if (array_key_exists($this->getRequest()->getParamByName('key'), $filterColumns)) {
            $filters = $filterColumns[$this->getRequest()->getParamByName('key')];
        } else {
            $filters = array();
        }
        $this->getFilters($filters, $this->getRequest()->getParamByName('key'));
        $this->addToView(
            'entries', $this->getEntries($this->getRequest()->getParamByName('key'))
        );
        $this->addToView('type', ucfirst($this->getRequest()->getParamByName('key')));
        $this->addToView('naviActive', $this->getRequest()->getParamByName('key'));
    }

    public function filterAction()
    {
        $filters = $this->getRequest()->getParams();
        if (!array_key_exists('type', $filters)) {
            $filters['type'] = $filters['key'];
        }
        unset($filters['key']);
        foreach ($filters as $k => $v) {
                $filters[$k] = urldecode($v);
        }
        $this->getFilters(array_keys($filters), $this->getRequest()->getParamByName('key'));
        foreach ($filters as $k => $v) {
            if (empty($v)) {
                unset($filters[$k]);
            }
        }
        $this->addToView('entries', $this->getEntries($this->getRequest()->getParamByName('key')));
        $this->addToView('type', ucfirst($filters['type']));
        $this->addToView('naviActive', $filters['type']);
        $this->addToView('filtersActive', array_values($filters));
    }

    /**
     * @param string $key
     * @return mixed
     */
    protected function getEntries($key)
    {
        $collection = $this->mapKeyToCollection($key);
        return $this->{$collection}->findAllWithOrder();
    }

    /**
     * @param array $columns
     * @param string $key
     */
    protected function getFilters(array $columns, $key)
    {
        $collection = $this->mapKeyToCollection($key);
        foreach ($columns as $key => $column) {
            unset($columns[$key]);
            $columns[$column] = $this->{$collection}->getConnection()->distinct($column);
        }
        $this->addToView('filters', $columns);
    }

    /**
     * @param $key
     * @return mixed
     */
    private function mapKeyToCollection($key)
    {
        $key2CollectionMap = array(
            'apacheAccess' => 'apachelogs',
            'apacheError' => 'apachelogs',
            'Syslog' => 'syslogs',
            'others' => 'otherlogs',
            'Pydio' => 'pydiologs'
        );

        $collection = $key2CollectionMap[$key];
        return $collection;
    }

//    public function testAction()
//    {
//        $db = \Mvc\System::getInstance()->database();
//        $cursor = $db->selectCollection('test', 'cartoons')->find();
//        foreach ($cursor as $document) {
//            \Mvc\Helper\Debug::dump($document);
//            //echo $document["title"] . "\n";
//        }
//    }
}
