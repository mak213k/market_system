<?php

namespace App\Services;

if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}

use App\Repositories\ProductTypeRepository;
use App\Models\ProductType;

class ProductTypeService{

    private $ProductTypeRepository;

    public function __construct(ProductTypeRepository $ProductTypeRepository){

        $this->ProductTypeRepository = $ProductTypeRepository;
    }

    public function getById($id)
    {
        return $this->ProductTypeRepository->getById($id);
    }

    public function getAllProductType()
    {
        return $this->ProductTypeRepository->getAll();
    }

    public function getTaxProductTypeById($id)
    {
        return $this->ProductTypeRepository->getTaxProductTypeById($id);
    }

    public function createProductType($name, $idTax){
        $productType  =new ProductType();
        $productType->setName($name);
        
        return $this->ProductTypeRepository->save($productType, $idTax);
    }

    public function updateProductType($id, $name,$idTax){
        $productType = $this->ProductTypeRepository->getById($id);
        $productType->setName($name);
        
        if($productType){

            return $this->ProductTypeRepository->update($productType,$idTax);
        }

        return 0;
    }
    
    public function deleteProductType($id){
        $productType = $this->ProductTypeRepository->getById($id);

        if($productType){
            return $this->ProductTypeRepository->delete($productType);
        }

        return false;
    }
    
}