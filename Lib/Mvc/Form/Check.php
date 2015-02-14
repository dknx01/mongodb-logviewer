<?php
/**
 * the default form check definition
 * 
 * PHP version >=5.3
 * 
 * @package Mvc\Form
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Form;
use \Mvc\Form\Check\CheckAbstract as CheckAbstract;

class Check extends CheckAbstract
{
    /**
     * @see \Mvc\Form\Check\CheckAbstract
     * 
     * @return boolean
     */
    public function check()
    {
        return true;
    }
}
