<?php 

namespace App\Services;


if( file_exists('..\autoload.php') ){
    
    require_once '..\autoload.php';
}

use App\Repositories\ProductRepository;
use App\Models\Product;

class ProductService{

    private $productRepository;

    public function __construct(ProductRepository $ProductRepository ){
        $this->productRepository = $ProductRepository;
    }

    public function getProductById($id){
        
        return $this->productRepository->getById($id);
    }

    public function getAllProduct()
    {
        return $this->productRepository->getAll();
    }

    public function createProduct($name, $description, $price, $product_type){
        
        $product = new Product();
        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setProductTipe($product_type);
        
        

        return $this->productRepository->save($product);
    }

    public function updateProduct($id, $name, $description, $price, $product_type){
        $product = $this->productRepository->getById($id);

        if($product){
            $product->setName($name);
            $product->setDescription($description);
            $product->setPrice($price);
            $product->setProductTipe($product_type);

            return $this->productRepository->update($product);
        }
        return false;
    }

    public function deleteProduct($id) {
        $product = $this->productRepository->getById($id);

        if ($product) {
            $this->productRepository->delete($product);
        }

        return $product;
    }
}