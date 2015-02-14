<?php
/**
 * class for the check errors
 * 
 * PHP version >=5.3
 * 
 * @package Mvc\Form\Check
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Form\Check;

class Error
{
    /**
     * contains all errors
     * @var array
     */
    protected $errors = array();
    /**
     * add a new error to the collection
     * 
     * @param string $element name of the form element
     * @param string $message error message
     * 
     * @return \Mvc\Form\Check\Error
     */
    public function addError($element, $message)
    {
        $this->errors[$element] = $message;
        return $this;
    }
    /**
     * returns the error message for an element
     * 
     * @param string $element name of the element
     * 
     * @return type
     */
    public function getError($element)
    {
        return $this->errors[$element];
    }
    /**
     * returns all errors
     * 
     * @return array
     */
    public function getAllErrors()
    {
        return $this->errors;
    }
    /**
     * the numbers of errors in this collection
     * 
     * @return int
     */
    public function errorNumbers()
    {
        return (int)count($this->errors);
    }
}
