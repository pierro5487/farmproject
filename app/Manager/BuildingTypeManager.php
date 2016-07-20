<?php

namespace Manager;

class BuildingTypeManager extends \W\Manager\Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('type_building');
    }
}