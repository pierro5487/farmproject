<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22/07/2016
 * Time: 15:22
 */

namespace Manager;


class MarketManager extends \W\Manager\Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('market_items');
    }

    public function deleteAll($pdo)
    {
        $sql = 'DELETE FROM market_items ';
        $pdo->exec($sql);
    }

    public function getMarketAnimalsList($pdo)
    {
        $sql = 'SELECT *,market_items.id as idMarket FROM market_items INNER JOIN species ON id_species = species.id';
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }
}