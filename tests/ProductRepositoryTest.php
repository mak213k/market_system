<?php 

namespace Tests;


//use App\autoload;

require 'App\autoload.php';
//require 'App\Config\config.php';


use PHPUnit\Framework\TestCase;
use App\Repositories\ProductRepository;

class ProductRepositoryTest extends TestCase
{
    public function testProductRepository()
    {
        $ProductRepository = new ProductRepository();
        $this->assertEquals( $ProductRepository->getAll()[0]['id_product'], 1 );
        
    }
}