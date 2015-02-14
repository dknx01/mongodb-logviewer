<?php

namespace Mvc;
use \Mvc as Mvc;

class Cli extends Application
{
    public function __construct()
    {
        $this->request = System::getInstance()->getRequest();
    }
}