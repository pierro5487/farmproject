<?php

namespace Manager;

class ConnectManager extends \W\Manager\Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('users');
    }

    public function connectPdo()
    {
        return $this->dbh;
    }

    public function deleteToken($pdo,$id_user)
    {
        $req=$pdo->prepare('DELETE FROM recovery_token WHERE id_user=:id_user');
        $req->execute(array('id_user'=>$id_user));
        return true;
    }
}