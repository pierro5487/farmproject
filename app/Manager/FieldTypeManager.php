<?php

namespace Manager;

class FieldTypeManager extends \W\Manager\Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('variety_cereals');
    }
}