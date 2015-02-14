<?php
/**
 * define a html textarea element
 * 
 * PHP version >=5.3
 * 
 * @package Mvc\Form\Element
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Form\Element;
use \Mvc\Form\Element\ElementAbstract as ElementAbstract;

class Textarea extends ElementAbstract
{
    /**
     * the value
     * @var string
     */
    protected $value = '';
    /**
     * width in columns
     * @var int
     */
    private $cols = 10;
    /**
     * height in rows
     * @var int
     */
    private $rows = 10;
    /**
     * @see \Mvc\Form\Element\ElementAbstract
     */
    public function definition()
    {
        $this->setElementType('textarea');
    }
    /**
     * 
     * @see \Mvc\Form\Element\Abstract
     * 
     * @return string
     */
    public function render()
    {
        $form = '<textarea ';
        $form .= 'id="' . $this->getId() . '" ';
        $form .= 'name="' . $this->getName() . '" ';
        $form .= 'class="' . $this->getClass() . '" ';
        $form .= $this->renderAttributes();
        $form .= 'cols="' . $this->getCols() . '" ';
        $form .= 'rows="' . $this->getRows() . '" ';
        $form .= '>';
        $form .= $this->getValue();
        $form .= '</textarea>';
        return $form;
    }
    /**
     * returns the value
     * 
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * set the value data
     * 
     * @param string $value value data
     * 
     * @return \Mvc\Form\Element\Textarea
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    /**
     * returns the width
     * 
     * @return int
     */
    public function getCols()
    {
        return $this->cols;
    }
    /**
     * set the width
     * 
     * @param int $cols number of columns
     * 
     * @return \Mvc\Form\Element\Textarea
     */
    public function setCols($cols)
    {
        $this->cols = $cols;
        return $this;
    }
    /**
     * return the height
     * 
     * @return int
     */
    public function getRows()
    {
        return $this->rows;
    }
    /**
     * set the height
     * 
     * @param int $rows number of rows
     * 
     * @return \Mvc\Form\Element\Textarea
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
        return $this;
    }
}
