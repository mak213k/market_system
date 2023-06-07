<?php

namespace App\Controller;

if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}

use App\Repositories\Repository;
use App\Services\TaxService;
use App\Controller\controller;
use App\Repositories\TaxRepository;



class sallesController implements controller
{
    private $sallesService;

    public function __construct(SallesService $sallesService )
    {
        $this->sallesService = $sallesService;
    }

    public function index()
    {
        
        $dados = $this->sallesService->getAll();

        return $dados;
    }

    public function query($id)
    {
        
        return $this->sallesService->getTaxById($id);
    }

    public function insert()
    {
        
        $taxPercentage = str_replace( ',', '.', $taxPercentage);
        $tax = $this->taxService->createProductType($description, $taxPercentage);
        return $tax;
    }

    public function update( $id, $description, $taxPercentage)
    {   
        
        $taxPercentage = str_replace( ',', '.', $taxPercentage);
        $tax = $this->taxService->updateProductType($id, $description, $taxPercentage);
        return $tax;
    }

    public function delete($id)
    {
        $tax = $this->taxService->deleteProductType($id);
        return $tax;
    }

}





if(isset($_GET['method'])){

    $database = Repository::getInstance();
    $sallesRepository = new SallesRepository($database);
    $sallesService = new SallesService($sallesRepository);
    $sallesController = new sallesController($sallesService);
    

    switch($_GET['method'])
    {   
        
        case 'insert':
           exit('fim');
            $description = $_POST['description'];
            $taxPercentage = $_POST['tax_percentage'];

            if( $taxController->insert( $description, $taxPercentage ) == 1 ){
                
                $message = "Gravado com sucesso";
                $status = True;
            }else{

                $message = "Ops. Houve algum erro";
                $status = False;
            }

            die( json_encode( array("status" => $status, "message"=>$message) ) );
            break;
        
    }
}

?>