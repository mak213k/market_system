<?php

namespace App\Controller;

if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}

use App\Repositories\Repository;
use App\Services\ProductTypeService;
use App\Controller\controller;
use App\Repositories\ProductTypeRepository;

use App\Services\TaxService;
use App\Repositories\TaxRepository;
 


class productTypeController implements controller
{
    private $productTypeService;

    public function __construct(ProductTypeService $productTypeService )
    {
        $this->productTypeService = $productTypeService;
    }

    public function index()
    {
        return $this->productTypeService->getAllProductType();
    }

    public function query($id)
    {
        
        return $this->productTypeService->getById($id);
    }

    public function getProductTypeTaxByIdProductType($id)
    {
        return $this->productTypeService->getTaxProductTypeById($id);
    }

    public function insert($name, $idTax)
    {
        
        $product = $this->productTypeService->createProductType($name, $idTax);
        return $product;
    }

    public function update( $id, $name, $idTax)
    {
        $product = $this->productTypeService->updateProductType($id, $name, $idTax);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->productTypeService->deleteProductType($id);
        return $product;
    }

}





if(isset($_GET['method'])){

    $database = Repository::getInstance();
    $productTypeRepository = new ProductTypeRepository($database);
    $productTypeService = new ProductTypeService($productTypeRepository);
    $productTypeController = new productTypeController($productTypeService);
    
    

    switch($_GET['method'])
    {   
        case 'edit':
            
            $dadosProduct = $productTypeController->query( intval($_POST['id']) );
            $taxRepository = new TaxRepository($database);
            $taxService = new TaxService($taxRepository);

            $dadosTax = $taxService->getAllTax();
            $dadosProductTypeTax = $productTypeController->getProductTypeTaxByIdProductType( intval($_POST['id']) );
            
            
            require_once '../frontend/register_product_type.php';
            break;
        case 'formulario':

            
            $taxRepository = new TaxRepository($database);
            $taxService = new TaxService($taxRepository);
            //var_dump($taxService->getAllTax());

            $dadosTax = $taxService->getAllTax();
            
            require_once '../frontend/register_product_type.php';
            
            break;
        case 'insert':
           
            $name = $_POST['name'];
            $idTax = $_POST['tax_id'];
            
            if( $productTypeController->insert( $name, $idTax ) == 1 ){
                
                $message = "Gravado com sucesso";
                $status = True;
            }else{

                $message = "Ops. Houve algum erro";
                $status = False;
            }

            die( json_encode( array("status" => $status, "message"=>$message) ) );
            break;
        case 'update':

            $name = $_POST['name'];
            $idTax = intval($_POST['tax_id']);
            $id_product_type = intval($_POST['id_product_type']);

            if( $productTypeController->update( $id_product_type, $name, $idTax ) ){
                
                $message = "Gravado com sucesso";
                $status = True;
            }else
            {
                $message = "Ops. Houve algum erro";
                $status = False;
            }
            die( json_encode( array("status" => $status, "message" => $message) ) );
            break;
        case 'delete':

            if( $productTypeController->delete( intval($_POST['id']) ) ){
                
                $message = "Gravado com sucesso";
                $status = True;
            }else
            {
                $message = "Ops. Houve algum erro";
                $status = False;
            }
            die( json_encode( array("status" => $status, "message" => $message) ) );
            break;
            
        case 'consult':
            echo "consult";
            break;
    }
}

?>