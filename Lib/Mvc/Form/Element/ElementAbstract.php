<?php
/**
 * abstract class for all html form elements
 * 
 * PHP version >=5.3
 * 
 * @package \Mvc\Form\Element
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Form\Element;
use \Mvc\Form\Check as CheckClass;
use \Mvc\Form\Check\CheckAbstract as CheckAbstract;
use \stdClass;

abstract class ElementAbstract
{
    /**
     * element type e.g. input, checkbox
     * @var string
     */
    protected $elementType = '';
    /**
     * value for the name attribute
     * @var string
     */
    protected $name = '';
    /**
     * value for the id attribute
     * @var string
     */
    protected $id = '';
    /**
     * value of the class attribute
     * @var string
     */
    protected $class = '';
    /**
     * list with additional attributes
     * @var \stdClass
     */
    protected $attributes = null;
    /**
     * the check definition
     * @var \Mvc\Form\Check\Abstract
     */
    protected $check = null;
    /**
     * the constructor
     */
    public function __construct()
    {
        $this->attributes = new stdClass();
        $this->check = new CheckClass();
        $this->definition();
    }
    /**
     * define the form element
     */
    abstract function definition();
    /**
     * the elements render function
     */
    abstract function render();
    /**
     * get the type of the form element
     * 
     * @return string
     */
    public function getElementType()
    {
        return $this->elementType;
    }
    /**
     * set the type of the form element
     * 
     * @param string $elementType the element type e.g. input
     * 
     * @return \Mvc\Form\Element\Abstract
     */
    public function setElementType($elementType)
    {
        $this->elementType = $elementType;
        return $this;
    }
    /**
     * get the name attribute
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * sett the name attribute
     * 
     * @param string $name name value
     * 
     * @return \Mvc\Form\Element\Abstract
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * get the id attribute
     * 
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * set the id attribute
     * 
     * @param string $id id value
     * 
     * @return \Mvc\Form\Element\Abstract
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * get the class attribute
     * 
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
    /**
     * get the class attribute
     * 
     * @param string $class class value
     * 
     * @return \Mvc\Form\Element\Abstract
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }
    /**
     * get all additional attributes
     * 
     * @return stdClass
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
    /**
     * set all additional attributes
     * 
     * @param stdClass $attributes additional attributes
     * 
     * @return \Mvc\Form\Element\Abstract
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }
    /** 
     * adds an additional attribute
     * 
     * @param string $name attribute name
     * @param string $value attribute value
     * 
     * @return \Mvc\Form\Element\Abstract
     */
    public function addAttribute($name, $value)
    {
        $this->attributes->$name = $value;
        return $this;
    }
    /**
     * get an attribute by its name
     * 
     * @param string $name attribute name
     * 
     * @return string
     */
    public function getAttribute($name)
    {
        return $this->attributes->$name;
    }
    /**
     * render all additional attributes
     * 
     * @return string
     */
    protected function renderAttributes()
    {
        $attributes = '';
        foreach ($this->getAttributes() as $key => $value) {
            $attributes .= $key . '="' . $value . '" ';
        }
        return $attributes;
    }
    /**
     * the check definition
     * 
     * @return Form_Check_Abstract
     */
    public function getCheck()
    {
        return $this->check;
    }
    /**
     * set the check definition
     * 
     * @param \Mvc\Form\Check\Abstract $check check definition class
     * 
     * @return \Mvc\Form\Element\Abstract
     */
    public function setCheck(CheckAbstract $check)
    {
        $this->check = $check;
        return $this;
    }
    /**
     * run the check for this element
     * 
     * @return mixed
     */
    public function check()
    {
        return $this->check->check();
    }
}
