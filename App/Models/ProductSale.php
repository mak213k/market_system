<?php


namespace App\Models;

class Sale{

    public function __construct(){
        
    }

    private $idProduct;
    private $idSale;

    public function getIdProduct(){
        return $this->idProduct;
    }

    public function setIdProduct($idProduct){
        $this->idProduct = $idProduct;
    }

    public function getIdSale(){
        return $this->idSale;
    }

    public function setIdSale($idSale){
        $this->idSale = $idSale;
    }
   
}