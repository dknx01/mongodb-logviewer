<?php
/**
 * the abstract class for all form entries
 * 
 * PHP version >=5.3
 * 
 * @package Mvc\Form
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Form\Entry;

abstract class EntryAbstract
{
    /**
     * renders the entry
     * 
     * @return string
     */
    abstract function render();
}