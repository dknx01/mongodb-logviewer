<?php
/**
 * define a form select list
 * 
 * PHP version >=5.3
 * 
 * @package Mvc\Form\Element
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Form\Element;
use \Mvc\Form\Element\ElementAbstract as ElementAbstract;

class SelectList extends ElementAbstract
{
    /**
     * list with all options elements
     * @var array
     */
    private $options = array();
    /**
     * 
     * @see \Mvc\Form\Element\ElementAbstract
     * 
     * @return \Mvc\Form\Element\SelectList
     */
    public function definition()
    {
        $this->setElementType('selectlist');
        return $this;
    }
    /**
     * 
     * @see  \Mvc\Form\Element\ElementAbstract
     * 
     * @return string
     */
    public function render()
    {
        $form = '<select ';
        $form .= 'name="' . $this->getName() . '" ';
        $form .= 'id="' . $this->getId() . '" ';
        $form .= 'name="' . $this->getName() . '" ';
        $form .= 'class="' . $this->getClass() . '" ';
        $form .= $this->renderAttributes();
        $form .= '>' . PHP_EOL;
        $form .= $this->proccessOptions();
        $form .=  PHP_EOL . '</select>';
        return $form;
    }
    /**
     * render all options
     * 
     * @return string
     */
    private function proccessOptions()
    {
        $options = '';
        foreach ($this->options as $group => $entry) {
            if ($entry['group'] == false) {
                $options .= $this->proccessOption($entry['options']);
            } elseif ($entry['group'] == true) {
                $options .= '<optgroup ';
                $options .= 'label="' . $group . '"';
                $options .= '>' . PHP_EOL;
                $options .= '</optgroup>' . PHP_EOL;
                foreach ($entry['options'] as $option) {
                    $options .= $this->proccessOption($option);
                }
            }
        }
        return $options;
    }
    /**
     * render one option
     * 
     * @param array $option the options
     * 
     * @return string
     */
    private function proccessOption($option) {
        $html = '<option';
        $html .= is_null($option['name']) ? '' : ' name="' . $option['name'] . '"';
        $html .= $option['selected'] == true ? ' selected="selected"' : '';
        $html .= '>';
        $html .= $option['value'];
        $html .= '</option>';
        return $html . PHP_EOL;
    }
    /**
     * add one option
     * 
     * @param mixed $value option value
     * @param string|null $name name attribute
     * @param string|null $group name of the group
     * @param boolean $selected is this option selected
     * 
     * @return \Mvc\Form\Element\SelectList
     */
    public function addOption($value, $name = null, $group = null, $selected = false)
    {
        $option = array(
                'name' => $name,
                'value' => $value,
                'selected' => $selected
                );
        if (is_null($group)) {
            $entry = array(
                        'group' => false,
                        'options' => $option
                    );
            $this->options[] = $entry;
        } else {
            if (array_key_exists($group, $this->options)) {
                $this->options[$group]['options'][] = $option;
            } else {
                $this->options[$group]['group'] = true;
                $this->options[$group]['options'][] = $option;
            }
        }
        return $this;
    }
}
