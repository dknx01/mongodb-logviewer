<?php
namespace Application\Db;
use \Mvc\Db\Mapper as Mapper;

class TestMapper extends Mapper
{
    public function __construct()
    {
        $mapper = array(
            'id' => 'id',
            'name' => 'testName'
        );
        $this->setMapper($mapper)
             ->getPrimary('id');
    }
}
