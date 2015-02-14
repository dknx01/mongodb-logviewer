<?php
/**
 * define an input element
 * 
 * PHP version >=5.3
 * 
 * @package Form\Element
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Form\Element;
use \Mvc\Form\Element\ElementAbstract as ElementAbstract;

class Input extends ElementAbstract
{
    /**
     * the input type
     * @var string
     */
    private $type = 'text';
    /**
     * the value data
     * @var string
     */
    private $value = '';
    /**
     * 
     * @see \Mvc\Form\Element\ElementAbstract
     * 
     * @return \Mvc\Form\Element\Input
     */
    public function definition()
    {
        $this->setElementType('input');
        return $this;
    }
    /**
     * 
     * @see \Mvc\Form\Element\ElementAbstract
     * 
     * @return string
     */
    public function render()
    {
        $form = '<input ';
        $form .= 'type="' . $this->getType() . '" ';
        $form .= 'id="' . $this->getId() . '" ';
        $form .= 'name="' . $this->getName() . '" ';
        $form .= 'class="' . $this->getClass() . '" ';
        $form .= $this->renderAttributes();
        $form .= 'value="' . $this->getValue() . '" ';
        $form .= '/>';
        return $form;
    }

    /**
     * get the input type
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * set the input type
     * 
     * @param string $type vtype value
     * 
     * @return \Mvc\Form\Element\Input
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    /**
     * the value data
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
     * @return \Mvc\Form\Element\Input
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
