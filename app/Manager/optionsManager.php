<?php 

namespace Manager;


class OptionsManager extends \W\Manager\Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('options');
    }

    public function getTime()
    {
        $pdo=$this->dbh;
        $req=$pdo->query('SELECT * FROM options WHERE option_name = \'time\'');
        $donnees=$req->fetch();
        return $donnees['option_value'];
    }

    public function getTimestampMarket()
    {
        $pdo=$this->dbh;
        $req=$pdo->query('SELECT * FROM options WHERE option_name = \'timestamp_market\'');
        $donnees=$req->fetch();
        return $donnees['option_value'];
    }

    public function updateTimestamp($time)
    {
        $pdo=$this->dbh;
        $req=$pdo->prepare('UPDATE options SET option_value =:time WHERE option_name = \'timestamp_market\'');
        $req->execute(array('time'=>$time));
    }
}