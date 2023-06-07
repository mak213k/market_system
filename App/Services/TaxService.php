<?php

namespace App\Services;

if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}

use App\Repositories\TaxRepository;
use App\Models\Tax;

class TaxService{

    private $TaxRepository;

    public function __construct(TaxRepository $TaxRepository){

        $this->TaxRepository = $TaxRepository;
    }

    public function getTaxById($id)
    {
        return $this->TaxRepository->getById($id);
    }

    public function getAllTax()
    {
        return $this->TaxRepository->getAll();
    }

    public function getTaxByIdProduct($id)
    {
        exit('dim');
        return $this->TaxRepository->getTaxByIdProduct($id);
    }

    public function createProductType( $description, $taxPercentage ){
        
        $tax  =new Tax();
        $tax->setDescription( $description );
        $tax->setTaxPercentage( $taxPercentage );

        return $this->TaxRepository->save($tax);
    }

    public function updateProductType($id, $description, $taxPercentage ){
        
        $productType = $this->TaxRepository->getById($id);
        $productType->setDescription($description);
        $productType->setTaxPercentage( $taxPercentage );

        if($productType){

            return $this->TaxRepository->update($productType);
        }

        return 0;
    }
    
    public function deleteProductType($id){
        $productType = $this->TaxRepository->getById($id);

        if($productType){
            return $this->TaxRepository->delete($productType);
        }

        return false;
    }
    
}