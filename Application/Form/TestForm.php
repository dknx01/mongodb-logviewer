<?php
namespace Application\Form;
use \Mvc\Form\FormAbstract as Form;
use \Mvc\Form\Element as Element;
use \Application\Form\TestCheck as Testcheck;
use \Mvc\System as System;

class TestForm extends Form
{
    public function form()
    {
        $this->addAttribute('onchange', 'alert()');
        $input1 = new Element\Input();
        $this->addElement($input1);
        $input2 = new Element\Input();
        $input2->setName('name')->addAttribute('size', 50);
        $this->addElement($input2);
        $textarea = new Element\Textarea();
        $this->addElement($textarea);
        $selectList = new Element\SelectList();
        $selectList->addOption('Select1')
                   ->addOption('Select2');
        $selectList->addOption('SubSelect1', null, 'Gruppe1');
        $selectList->addOption('SubSelect2', null, 'Gruppe1');
        $selectList->addOption('SubSelect1', null, 'Gruppe2');
        $this->addElement($selectList);
        $input4 = new Element\Input();
        $check = new Testcheck();
        $request = System::getInstance()->getRequest();
        $check->setRequestData($request->getParamByName('testname'));
        $input4->setName('testname')->setCheck($check);
        $this->addElement($input4, 'test1');
        $input3 = new Element\Input();
        $input3->setType('submit')->setValue('WEG')->setName('weg');
        $this->addElement($input3);
    }
}