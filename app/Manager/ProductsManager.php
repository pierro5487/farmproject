<?php

namespace Manager;

class ProductsManager
{

    public function getUserProductsInformations($pdo, $idUser)
    {

        // SELECT s2.quantity, vc.name FROM `stocks2` s2 JOIN users u ON (s2.id_users=u.id), variety_cereals vc where s2.stock_type='field' AND s2.`id_product`=vc.id GROUP BY vc.id
        // SELECT s2.quantity, pa.name FROM `stocks2` s2 JOIN  users u ON (s2.id_users=u.id), product_animal pa where s2.stock_type='animal' AND s2.`id_product`=pa.id GROUP BY pa.id
        $sql = 'SELECT s.quantity, vc.name,s.id idStock,price_sale,image_path,unity FROM `stocks` s JOIN variety_cereals vc ON vc.id=s.id_product where s.stock_type=\'field\' AND s.id_users= :id GROUP BY vc.id UNION SELECT s.quantity, pa.name,s.id idStock,price_sale,image_path,unity  FROM `stocks` s JOIN product_animal pa ON pa.id =s.id_product where s.stock_type=\'animal\' AND s.id_users= :id GROUP BY pa.id';
        //$sql = 'SELECT *, count(*) as count FROM stocks INNER JOIN product_animal ON id_product_animal = product_animal.id WHERE id_users LIKE :id group by id_species';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $idUser);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    public function getProduct($pdo,$idProduct)
    {
        $sql = $sql = 'SELECT s.quantity, vc.name,s.id idStock,price_sale,image_path,unity FROM `stocks` s JOIN variety_cereals vc ON vc.id=s.id_product where s.stock_type=\'field\' AND s.id= :id GROUP BY vc.id UNION SELECT s.quantity, pa.name,s.id idStock,price_sale,image_path,unity  FROM `stocks` s JOIN product_animal pa ON pa.id =s.id_product where s.stock_type=\'animal\' AND s.id= :id GROUP BY pa.id';
        $req=$pdo->prepare($sql);
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $idProduct);
        $stmt->execute();
        return $stmt->fetch();
    }
}