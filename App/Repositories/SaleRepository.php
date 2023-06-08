<?php 

namespace App\Repositories;

if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}


use App\Repositories\Repository;
use App\Models\Sale;
use PDO;

class SaleRepository {

    protected Repository $database;

    public function __construct(Repository $database){
        $this->database = $database;
    }

    public function getById($id) {
        
        $statement = $this->database->getConnection()
        ->prepare("  ");

        $statement->bindParam(':id', $id);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            $tax = new Sale();
            $tax->setId($data['id_tax']);
            $tax->setDescription($data['description']);
            
            return $tax;
        }

        return null;
    }

    /** Bring all sales  */
    public function getAll() {

        $sql = " SELECT ID_PRODUCT, ID_SALE, PRICE, 
		REPLACE(TAX_PERCENTAGE_TAX::VARCHAR, '.', ',')  AS TAX_PERCENTAGE_TAX 
		FROM PRODUCT_SALE ";     

        return $this->database->getQuery($sql);
    }

    public function save( $sale ) {
        
        $this->database->getConnection()->beginTransaction();

        $statement = $this->database->getConnection()
        ->prepare(" INSERT INTO SALE(ID_SALE, UPDATE_AT, CREATE_AT, DELETED_AT ) 
		VALUES(NEXTVAL('id_sale_seq'), CURRENT_TIME, CURRENT_TIME, null ) RETURNING ID_SALE ");
        

        if( $statement->execute() )
        {
            $id_sale_temp = $statement->fetch( PDO::FETCH_ASSOC );
            $id_sale = $id_sale_temp['id_sale'];

            foreach($sale as $saleValue ){

                
               
                $statementProductSale = $this->database->getConnection()
                ->prepare(" INSERT INTO PRODUCT_SALE(ID_PRODUCT_SALE, ID_PRODUCT, ID_SALE, QUANTITY, PRICE, TAX_PERCENTAGE_TAX ) 
                SELECT nextval('id_product_sale_seq') AS ID_PRODUCT_SALE, 
                ID_PRODUCT, $id_sale AS ID_SALE, {$saleValue["quantity"]} AS QUANTITY, PRICE, TAX_PERCENTAGE
                FROM PRODUCT
                INNER JOIN PRODUCT_TYPE
                ON PRODUCT.PRODUCT_TYPE_ID = PRODUCT_TYPE.ID_PRODUCT_TYPE
                INNER JOIN PRODUCT_TYPE_TAX
                ON PRODUCT_TYPE.ID_PRODUCT_TYPE = PRODUCT_TYPE_TAX.ID_PRODUCT_TYPE
                INNER JOIN TAX 
                ON PRODUCT_TYPE_TAX.ID_TAX = TAX.ID_TAX
                WHERE ID_PRODUCT = '{$saleValue["id_product"]}'; ");

                $statementProductSale->execute();
            }

            $this->database->getConnection()->commit();

            return true;
        }

        return false;
    }

    public function cancelSell(Sale $sale) {
        
        $statement = $this->database->getConnection()
        ->prepare(" UPDATE TAX SET DESCRIPTION = :description, TAX_PERCENTAGE = :tax_percentage WHERE ID_TAX= :id_tax ");
        $statement->bindValue( ':id_tax', $sale->getId() );
        $statement->bindValue( ':description', $sale->getDescription() );
        $statement->bindValue( ':tax_percentage',$sale->getTaxPercentage());

        return $statement->execute();
    }

    public function delete( Sale $sale ) {
       $statement = $this->database->getConnection()
       ->prepare('DELETE FROM TAX WHERE ID_TAX= :id');
       $statement->bindValue(':id', $sale->getId());

       return $statement->execute();
    }
}

//$teste = new ProductTypeRepository();
//var_dump($teste->getAll());exit();