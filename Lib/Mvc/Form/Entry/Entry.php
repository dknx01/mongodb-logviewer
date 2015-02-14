<?php
/**
 * class for one Entry in a form entry list
 * 
 * PHP version >=5.3
 * 
 * @package Mvc\Form
 * @author  dknx01 <e.witthauer@gmail.com>
 */
namespace Mvc\Form\Entry;
use \Mvc\Form\Entry\EntryAbstract as EntryAbstract;
use \Mvc\Form\Element\ElementAbstract as ElementAbstract;
use \Mvc\Form\Check as CheckClass;

class Entry extends EntryAbstract
{
    /**
     * the form element
     * @var \Mvc\Form\Element\ElementAbstract
     */
    protected $element = null;
    /**
     * the check definition
     * @var \Mvc\Form\Check\CheckAbstract
     */
    protected $check = null;
    /**
     * the constructor
     * 
     * @param \Mvc\Form\Element\ElementAbstract $element
     * @param \Mvc\Form\Check $check check class
     */
    public function __construct(ElementAbstract $element, CheckClass $check)
    {
        $this->element = $element;
        $this->check = $check;
    }
    /**
     * 
     * @see \Mvc\Form\Entry\EntryAbstract
     * 
     * @return string
     */
    public function render()
    {
        $entry = '';
        if ($this->element instanceof ElementAbstract 
            && method_exists($this->element, 'render')
        ) {
            $entry .= $entry->render() . PHP_EOL;
        }
        return $entry;
    }
}
