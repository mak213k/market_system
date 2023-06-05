<?php 

namespace App\Repositories;

if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}


use App\Repositories\Repository;
use App\Models\ProductType;
use PDO;

class ProductTypeRepository {

    protected Repository $database;

    public function __construct(Repository $database){
        $this->database = $database;
    }

    public function getById($id) {
        $statement = $this->database->getConnection()
        ->prepare(" SELECT * FROM PRODUCT_TYPE WHERE ID_PRODUCT_TYPE = :id ");
        $statement->bindParam(':id', $id);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            $product = new ProductType();
            $product->setId($data['id_product_type']);
            $product->setName($data['name']);
            
            return $product;
        }

        return null;
    }

    public function getTaxProductTypeById($id) {

        $statement = $this->database->getConnection()
        ->prepare(" SELECT * FROM PRODUCT_TYPE
        LEFT JOIN PRODUCT_TYPE_TAX
        ON PRODUCT_TYPE.ID_PRODUCT_TYPE = PRODUCT_TYPE_TAX.ID_PRODUCT_TYPE
        LEFT JOIN TAX
        ON PRODUCT_TYPE_TAX.ID_TAX = TAX.ID_TAX
        WHERE PRODUCT_TYPE.ID_PRODUCT_TYPE = :id ");

        $statement->bindParam(':id', $id);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        
        if($data){
            
            return $data;
        }

        return null;
    }

    public function getAll() {
        
        $sql = " SELECT * FROM PRODUCT_TYPE ";   
        return $this->database->getQuery($sql);
    }

    public function save(ProductType $productType, $idTax) {
       

        $this->database->getConnection()->beginTransaction();

        $statement = $this->database->getConnection()
        ->prepare("INSERT INTO PRODUCT_TYPE( ID_PRODUCT_TYPE, NAME ) 
        VALUES (nextval('id_product_type_seq') , :name ) RETURNING ID_PRODUCT_TYPE ");
        $statement->bindValue(':name', $productType->getName());
        

        if( $statement->execute() )
        {
            $id_product_type_temp = $statement->fetch( PDO::FETCH_ASSOC );
            $id_product_type = $id_product_type_temp["id_product_type"];
            $statement_product_type_tax = $this->database->getConnection()
            ->prepare("INSERT INTO PRODUCT_TYPE_TAX( ID_PRODUCT_TYPE, ID_TAX ) VALUES ( :id, :id_tax )");

            $statement_product_type_tax->bindValue(':id', $id_product_type);
            $statement_product_type_tax->bindValue(':id_tax', $idTax);
            
            $statement_product_type_tax->execute();

            $this->database->getConnection()->commit();
            
            return true;
        }
        
        $this->database->getConnection()->rollBack();
        return false;
    }

    public function update(ProductType $productType, $idTax) {
        
        $this->database->getConnection()->beginTransaction();
        
        $statement = $this->database->getConnection()
        ->prepare(" UPDATE PRODUCT_TYPE SET NAME = :name WHERE ID_PRODUCT_TYPE= :id_product_type");
        $statement->bindValue( ':id_product_type', $productType->getId() );
        $statement->bindValue(':name',$productType->getName());


        if( $statement->execute() )
        {
            
            $statement_product_type_tax = $this->database->getConnection()
            ->prepare("INSERT INTO PRODUCT_TYPE_TAX( ID_PRODUCT_TYPE, ID_TAX ) VALUES ( :id, :id_tax )");

            $statement_product_type_tax->bindValue(':id', $productType->getId());
            $statement_product_type_tax->bindValue(':id_tax', $idTax);
            
            $statement_product_type_tax->execute();

            $this->database->getConnection()->commit();
            
            return true;
        }
        return false;
    }

    public function delete( ProductType $ProductType ) {
       $statement = $this->database->getConnection()
       ->prepare('DELETE FROM PRODUCT_TYPE WHERE ID_PRODUCT_TYPE= :id');
       $statement->bindValue(':id', $ProductType->getId());

       return $statement->execute();
    }
}

//$teste = new ProductTypeRepository();
//var_dump($teste->getAll());exit();