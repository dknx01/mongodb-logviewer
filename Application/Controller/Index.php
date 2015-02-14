<?php
/**
 * the index controller
 * @author dknx01
 * @package Application\Controller
 */
namespace Application\Controller;
use Application\Db\LogsCollection;
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
     * @var LogsCollection
     */
    private $apachelogs;
    /**
     * @var MongoCollection
     */
    private $types;

    protected function up()
    {
        $this->apachelogs = new LogsCollection($this->serviceLocator());
        $this->types = $this->apachelogs->getAllUniqueFromColumn('type');
        $this->addToView('types', $this->types['retval']);
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
        $this->addToView('syslogNumber', $this->apachelogs->getEntriesNumberByType('syslog'));
        $this->addToView('otherEntriesNumber', $this->apachelogs->getEntriesNumberByType('random_logs'));
        $this->addToView('latestEntries', $this->apachelogs->getLastes());
        $this->addToView('allEntries', $this->apachelogs->getNumberOfEntries());

    }

    public function findByAction()
    {
        $this->getFilters(array('verb', 'httpversion'));
        $this->addToView(
            'entries', $this->apachelogs->findAllByColumnValue('type', $this->getRequest()->getParamByName('key'))
        );
        $this->addToView('type', ucfirst($this->getRequest()->getParamByName('key')));
        $this->addToView('naviActive', $this->getRequest()->getParamByName('key'));
    }

    public function filterAction()
    {
        $filters = $this->getRequest()->getParams();
        $filters['type'] = $filters['key'];
        unset($filters['key']);

        $this->getFilters(array_keys($filters));
        $this->addToView('entries', $this->apachelogs->getConnection()->find($filters));
        $this->addToView('type', ucfirst($this->getRequest()->getParamByName('key')));
        $this->addToView('naviActive', $this->getRequest()->getParamByName('key'));
        $this->addToView('filtersActive', array_values($filters));
    }

    protected function getFilters(array $columns)
    {
        foreach ($columns as $key => $column) {
            unset($columns[$key]);
            $columns[$column] = $this->apachelogs->getConnection()->distinct($column);
        }
        $this->addToView('filters', $columns);
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
