<?php
/**
 * class for handle html form fieldsets. A collection of entries.
 * 
 * PHP version >=5.3
 * 
 * @package Mvc\Form
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Form\Entry;
use \Mvc\Form\Entry\EntryAbstract as EntryAbstract;
use \Mvc\Form\Element\ElementAbstract;
use \stdClass;

class Fieldset extends EntryAbstract
{
    /**
     * the collection of entries
     * @var array
     */
    protected $elements = array();
    /**
     * the fieldset additional attributes
     * @var \stdClass
     */
    protected $attributes = null;
    /**
     * the fieldset legend text
     * @var string
     */
    protected $legend = '';
    /**
     * the legends attributes
     * @var \stdClass
     */
    protected $legendAttributes = null;
    /**
     * name of the fieldset as internal identifier
     * @var string
     */
    protected $name = '';
    /**
     * the constructor
     */
    public function __construct()
    {
        $this->attributes = new stdClass();
        $this->legendAttributes = new stdClass();
    }
    /**
     * adds a new form Element to this fieldset
     * 
     * @param \Mvc\Form\Element\ElementAbstract $entry the entry
     * 
     * @return \Mvc\Form\Entry\Fieldset
     */
    public function addElement(\Mvc\Form\Element\ElementAbstract $entry)
    {
        $this->elements[] = $entry;
        return $this;
    }
    /**
     * @see \Mvc\Form\EntryAbstract
     * 
     * @return string
     */
    public function render()
    {
        $entry = '';
        $entry .= '<fieldset ';
        foreach (get_object_vars($this->attributes) as $name => $value) {
            $entry .= $name . '="' . $value . '" ';
        }
        $entry .= '>' . PHP_EOL;
        if (!empty($this->legend)) {
            $entry .= '<legend ';
            if (count($this->legendAttributes) > 1) {
                foreach (get_object_vars($this->legendAttributes) as $name => $value) {
                    $entry .= $name . '="' . $value . '" ';
                }
            }
            $entry .= '>' . PHP_EOL;
            $entry .= htmlentities($this->legend) . '</legend>';
        }
        foreach ($this->elements as $element) {
            $entry .= $element->render() . PHP_EOL;
        }
        $entry .='</fieldset>';
        return $entry;
    }
    /**
     * the legend text
     * 
     * @return string
     */
    public function getLegend()
    {
        return $this->legend;
    }
    /**
     * set the legend text
     * 
     * @param string $legend legend text
     * 
     * @return \Mvc\Form\Entry\Fieldset
     */
    public function setLegend($legend)
    {
        $this->legend = $legend;
        return $this;
    }
    /**
     * the fieldset name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * set the fieldset name
     * 
     * @param string $name name value
     * 
     * @return \Mvc\Form\Entry\Fieldset
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * adds a new attribute to the legend tag
     * 
     * @param string $name attribute name
     * @param string $value attribute value
     * 
     * @return \Mvc\Form\Entry\Fieldset
     */
    public function addLegendAttribute($name, $value)
    {
        $this->legendAttributes->$name = $value;
        return $this;
    }
    /**
     * adds a new attribute to the fieldset tag
     * 
     * @param string $name attribute name
     * @param string $value attribute value
     * 
     * @return \Mvc\Form\Entry\Fieldset
     */
    public function addAttribute($name, $value)
    {
        $this->attributes->$name = $value;
        return $this;
    }
    /**
     * returns all elements of this fieldset
     * 
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }
}
