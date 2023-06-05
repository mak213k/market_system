<?php

namespace App\Repositories;

if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}



use App\Repositories\Repository;
use App\Models\Product;
use PDO;

class ProductRepository {
     
    protected Repository $database;

    public function __construct(Repository $database){
        $this->database = $database;
    }

    public function getById($id) {
        
        $statement = $this->database->getConnection()
        ->prepare(" SELECT ID_PRODUCT, PRODUCT.NAME, DESCRIPTION, PRICE, 
        PRODUCT_TYPE.NAME AS PRODUCT_TYPE, ID_PRODUCT_TYPE 
        FROM PRODUCT
        INNER JOIN PRODUCT_TYPE
        ON PRODUCT.PRODUCT_TYPE_ID = PRODUCT_TYPE.ID_PRODUCT_TYPE
        WHERE ID_PRODUCT = :id ");

        $statement->bindParam(':id', $id);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            $product = new Product();
            $product->setId($data['id_product']);
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setProductTipe($data['id_product_type']);
            
            return $product;
        }

        return null;
    }

    public function getAll() {
        $sql = " SELECT ID_PRODUCT, PRODUCT.NAME, DESCRIPTION, PRICE, PRODUCT_TYPE.NAME AS PRODUCT_TYPE FROM PRODUCT
        INNER JOIN PRODUCT_TYPE
        ON PRODUCT.PRODUCT_TYPE_ID = PRODUCT_TYPE.ID_PRODUCT_TYPE";
        return $this->database->getQuery($sql);
    }

    public function save(Product $product) {
        $statement = $this->database->getConnection()
        ->prepare( "INSERT INTO PRODUCT( ID_PRODUCT, NAME, DESCRIPTION, PRICE, PRODUCT_TYPE_ID) VALUES (nextval('id_product_seq'), :name, :description, :price, :productType )" );
        
        $statement->bindValue(':name', $product->getName());
        $statement->bindValue(':description', $product->getDescription());
        $statement->bindValue(':price', $product->getPrice());
        $statement->bindValue(':productType', $product->getProductTipe());

        return $statement->execute();
    }

    public function update(Product $Product) {
        $statement = $this->database->getConnection()
        ->prepare( " UPDATE PRODUCT SET NAME = :name, DESCRIPTION = :description, PRICE = :price, PRODUCT_TYPE_ID = :product_type WHERE ID_PRODUCT = :id_product " );
        $statement->bindValue(':id_product', $Product->getId());
        $statement->bindValue(':name', $Product->getName());
        $statement->bindValue(':description', $Product->getDescription());
        $statement->bindValue(':price', $Product->getPrice());
        $statement->bindValue(':product_type', $Product->getProductTipe());
        
        return $statement->execute();
    }

    public function delete(Product $Product) {
       $statement = $this->database->getConnection()
       ->prepare('DELETE FROM product WHERE ID_PRODUCT= :id');
       $statement->bindValue(':id', $Product->getId());

       return $statement->execute();
    }
}

//$ProductRepository = new ProductRepository();
//var_dump($ProductRepository->getAll()[0]['id_product']);exit();

//$ProductRepository->save();
