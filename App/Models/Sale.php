<?php


namespace App\Models;

class Sale{

    public function __construct(){
        
    }

    private $id;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

   
}