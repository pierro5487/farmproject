<?php 

namespace Manager;


class OptionsManager extends \W\Manager\Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('options');
    }

}