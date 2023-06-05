<?php


namespace App\Models;

class Tax{

    public function __construct(){
        
    }

    private $id;
    private $description;
    private $taxPercentage;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getTaxPercentage(){
        return $this->taxPercentage;
    }

    public function setTaxPercentage($taxPercentage){
        $this->taxPercentage = $taxPercentage;
    }
}