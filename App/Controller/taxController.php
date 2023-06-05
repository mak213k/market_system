<?php

namespace App\Controller;

if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}

use App\Repositories\Repository;
use App\Services\TaxService;
use App\Controller\controller;
use App\Repositories\TaxRepository;



class taxController implements controller
{
    private $taxService;

    public function __construct(TaxService $taxService )
    {
        $this->taxService = $taxService;
    }

    public function index()
    {
        
        $dados = $this->taxService->getAllTax();

        return $dados;
    }

    public function query($id)
    {
        
        return $this->taxService->getTaxById($id);
    }

    public function insert($description, $taxPercentage)
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
    $taxRepository = new TaxRepository($database);
    $taxService = new TaxService($taxRepository);
    $taxController = new taxController($taxService);
    

    switch($_GET['method'])
    {   
        case 'edit':
            
            $dadosTax = $taxController->query( intval($_POST['id']) );
            
            //return $dadosTax;
            //die( json_encode( array( "id" => $dadosTax->getId(), "description" => $dadosTax->getDescription() ) ) );
            require_once '../frontend/register_tax.php';
            break;
        case 'formulario':
            require_once '../frontend/register_tax.php';
            
            break;
        case 'insert':
           
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
        case 'update':

            $description = $_POST['description'];
            $taxPercentage = $_POST['tax_percentage'];

            if( $taxController->update( intval($_POST['id_tax']), $description, $taxPercentage ) ){
                
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

            if( $taxController->delete( intval($_POST['id']) ) ){
                
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