<?php

namespace App\Controller;

if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}

use App\Repositories\Repository;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use App\Controller\controller;


use App\Repositories\ProductTypeRepository;
use App\Services\ProductTypeService;
use App\Controller\productTypeController;


class productController implements controller
{
    private $productService;

    public function __construct(ProductService $productService )
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return $this->productService->getAllProduct();
    }

    public function query($id)
    {
        
        return $this->productService->getProductById($id);
    }

    public function insert($name, $description, $price, $product_type)
    {
        
        $product = $this->productService->createProduct($name,$description,$price, $product_type);
        return $product;
    }

    public function update( $id, $name,$description,$price,$product_type)
    {
        $product = $this->productService->updateProduct($id,$name,$description,$price, $product_type);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->productService->deleteProduct($id);
        return $product;
    }

}





if(isset($_GET['method'])){

    $database = Repository::getInstance();
    
    $productRepository = new ProductRepository($database);
    $productService = new ProductService($productRepository);
    $productController = new productController($productService);

    

    switch($_GET['method'])
    {   
        case 'edit':
            
            $dadosProduct = $productController->query( intval($_POST['id']) );
           
            $database = Repository::getInstance();
            $productTypeRepository = new ProductTypeRepository($database);
            $productTypeService = new ProductTypeService($productTypeRepository);
            
            $dadosProductType = $productTypeService->getAllProductType();
            
            
            require_once '../frontend/register_product.php';
            break;
        case 'formulario':
            
            $database = Repository::getInstance();
            $productTypeRepository = new ProductTypeRepository($database);
            $productTypeService = new ProductTypeService($productTypeRepository);
            
            $dadosProductType = $productTypeService->getAllProductType();

            

            require_once '../frontend/register_product.php';
            break;

        case 'insert':
           
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = str_replace(",",".",$_POST['price']);
            
            $product_type = $_POST['product_type_id'];

            

            if( $productController->insert( $name, $description, $price, $product_type ) == 1 ){
                
                $message = "Gravado com sucesso";
                $status = True;
            }else{

                $message = "Ops. Houve algum erro";
                $status = False;
            }

            die( json_encode( array("status" => $status, "message"=>$message) ) );
            break;
        case 'query_up_to_date_product':
            
            $idProduct = $_POST['id'];
            
            if( intval($idProduct) ){
            
                $dadosProduct = $productController->query($idProduct);
            
                $product = array();
                $i = 0;
                                                   
                    //var_dump($value['name']);
                    $product['id_product'][$i] = $dadosProduct->getId();
                    $product['name'][$i] = $dadosProduct->getName();
                    $product['price'][$i] = $dadosProduct->getPrice();
                    $i++;
                
                
                die( json_encode( array("id" => $product['id_product'], "name" => $product['name'], "price" => $product['price'] ) ) );
            
            }else{

                $dadosProduct = $productController->index();
            
                $product = array();
                $i = 0;

                foreach( $dadosProduct as $value )
                {
                    
                    //var_dump($value['name']);
                    $product['id_product'][$i] = $value['id_product'];
                    $product['name'][$i] = $value['name'];
                    $product['price'][$i] = $value['price'];
                    $i++;
                }
                
                die( json_encode( array("id" => $product['id_product'], "name" => $product['name'], "price" => $product['price'] ) ) );
    
            }

            break;
        case 'update':

            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $product_type = $_POST['product_type_id'];

            if( $productController->update( intval($_POST['id_product']), $name, $description, $price, $product_type ) ){
                
                $message = "Gravado com sucesso";
                $status = True;
            }else
            {

                $message = "Ops. Houve algum erro";
                $status = False;
            }
            die( json_encode( array("status" => $status, "message"=>$message) ) );
            break;
        case 'delete':

            if( $productController->delete( intval($_POST['id_product']) ) ){
                
                $message = "Gravado com sucesso";
                $status = True;
            }else
            {

                $message = "Ops. Houve algum erro";
                $status = False;
            }
            die( json_encode( array("status" => $status, "message"=>$message) ) );
            break;
            
        case 'consult':
            echo "consult";
            break;
    }
}

?>