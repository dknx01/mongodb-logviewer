<?php
namespace Application\Form;
use \Mvc\Form\Check\CheckAbstract as CheckAbstract;

class TestCheck extends CheckAbstract
{
    public function check()
    {
        $pattern = '/\d+/';
        if (preg_match($pattern, $this->getRequestData())) {
            return true;
        } else {
            return 'Only letters are allowed';
        }
    }
}