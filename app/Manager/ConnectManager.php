<?php

namespace Manager;

class ConnectManager extends \W\Manager\Manager
{
    public function connectPdo()
    {
        return $this->dbh;
    }
}