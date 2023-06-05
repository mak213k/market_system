<?php 

namespace App\Repositories;

if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}


use App\Repositories\Repository;
use App\Models\Tax;
use PDO;

class TaxRepository {

    protected Repository $database;

    public function __construct(Repository $database){
        $this->database = $database;
    }

    public function getById($id) {
        
        $statement = $this->database->getConnection()
        ->prepare(" SELECT ID_TAX, DESCRIPTION, 
        REPLACE(TAX_PERCENTAGE::VARCHAR, '.', ',') AS TAX_PERCENTAGE
        FROM TAX 
        WHERE ID_TAX = :id ");

        $statement->bindParam(':id', $id);
        $statement->execute();

        $data = $statement->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            $tax = new Tax();
            $tax->setId($data['id_tax']);
            $tax->setDescription($data['description']);
            
            return $tax;
        }

        return null;
    }

    public function getAll() {

        $sql = " SELECT ID_TAX, DESCRIPTION, 
        REPLACE(TAX_PERCENTAGE::VARCHAR, '.', ',')  AS TAX_PERCENTAGE
        FROM TAX ";     

        return $this->database->getQuery($sql);
    }

    public function save(TAX $tax) {
        
        $statement = $this->database->getConnection()
        ->prepare("INSERT INTO TAX( ID_TAX, DESCRIPTION, TAX_PERCENTAGE ) VALUES (nextval('id_tax_seq') , :description, :tax_percentage )");
        $statement->bindValue(':description', $tax->getDescription());
        $statement->bindValue(':tax_percentage', $tax->getTaxPercentage());

        if( $statement->execute() )
        {
            return true;
        }

        return false;
    }

    public function update(Tax $tax) {
        
        $statement = $this->database->getConnection()
        ->prepare(" UPDATE TAX SET DESCRIPTION = :description, TAX_PERCENTAGE = :tax_percentage WHERE ID_TAX= :id_tax ");
        $statement->bindValue( ':id_tax', $tax->getId() );
        $statement->bindValue( ':description', $tax->getDescription() );
        $statement->bindValue( ':tax_percentage',$tax->getTaxPercentage());

        return $statement->execute();
    }

    public function delete( Tax $tax ) {
       $statement = $this->database->getConnection()
       ->prepare('DELETE FROM TAX WHERE ID_TAX= :id');
       $statement->bindValue(':id', $tax->getId());

       return $statement->execute();
    }
}

//$teste = new ProductTypeRepository();
//var_dump($teste->getAll());exit();