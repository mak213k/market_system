<?php

namespace App\Controller;

if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}

use App\Repositories\Repository;
use App\Services\SaleService;
use App\Controller\controller;
use App\Repositories\SaleRepository;



class saleController
{
    private $saleService;

    public function __construct(SaleService $saleService )
    {
        $this->saleService = $saleService;
    }

    public function index()
    {
        
        $dados = $this->saleService->getAll();

        return $dados;
    }

    
    
    public function insert( $sale )
    {
        
        $tax = $this->saleService->createSale($sale);
        return $tax;
    }


}





if(isset($_GET['method'])){

    $database = Repository::getInstance();
    $saleRepository = new SaleRepository($database);
    $saleService = new SaleService($saleRepository);
    $saleController = new SaleController($saleService);
    

    switch($_GET['method'])
    {   
        
        case 'insert':
           
            $sale = array();
            $i = 0;

            foreach( $_POST as $value )
            {

                $sale[$i] = (array)json_decode( ($value) );
                $i++;
            }
           

            if( $saleController->insert( $sale ) == 1 ){
                
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