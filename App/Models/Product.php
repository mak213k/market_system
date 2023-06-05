<?php

namespace App\Models;


class Product {

    public function __construct(){
        
    }

    private $id;
    private $name;
    private $description;
    private $price;
    private $productType;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }
    
    public function getPrice(){
        return $this->price;
    }

    public function setPrice($price){
        $this->price = $price;
    }

    public function setProductTipe($productType){
        $this->productType = $productType;
    }

    public function getProductTipe(){
        return $this->productType;
    }

}

//$product = new Product();
//$product->setName('teste');
//echo $product->getName();