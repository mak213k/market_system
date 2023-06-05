<?php


namespace App\Models;

class ProductTypeTax{

    public function __construct(){
        
    }

    private $IdProductType;
    private $idTax;

    public function getIdTax(){
        return $this->idTax;
    }

    public function setIdTax($idTax){
        $this->idTax = $idTax;
    }

    public function getIdProductType(){
        return $this->IdProductType;
    }

    public function setIdProductType($IdProductType){
        $this->IdProductType = $IdProductType;
    }

}