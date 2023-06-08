<?php

namespace App\Services;

if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}

use App\Repositories\SaleRepository;
use App\Models\Sale;

class SaleService{

    private $SaleRepository;

    public function __construct(SaleRepository $SaleRepository){

        $this->SaleRepository = $SaleRepository;
    }

    public function createSale( $sale ){ 

        return $this->SaleRepository->save($sale);
    }

    public function getAll()
    {
        return $this->getAll();
    }
}