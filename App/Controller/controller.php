<?php 

namespace App\Controller;

//require_once 'class/autoload.php';

//use App\Services\Product

//$database = new Database($host, $db, $user, $password);


interface controller 
{

    public function index();

    public function query($id);

    //public function insert($name, $description, $price);

    //public function update();

    public function delete($id);
}

//var_dump($database->getQuery("select * from product"));