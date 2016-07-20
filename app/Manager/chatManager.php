<?php

namespace Manager;

class ChatManager
{
    public function getPost()
    {
        //je créé un objet pdo
        $controller = new \Manager\ConnectManager();
        $pdo = $controller->connectPdo();
        $req=$pdo->query('SELECT * FROM tchat ORDER BY date_created DESC LIMIT 5 ');
        return $req->fetchALL();
    }
}