<?php

namespace Tests;

//require 'App\autoload.php';

require_once 'App\autoload.php';

use PHPUnit\Framework\TestCase;
use App\Models\Product;

class ProductTest extends TestCase
{

    public function testId()
    {
        $Product = new Product();
        $Product->setId(1);
        $this->assertEquals( $Product->getId(), '1');
    }

    public function testGetAll()
    {
        $Product = new Product();
        $Product->setName('Teste');
        $this->assertEquals( $Product->getName(), 'Teste' );
    }

    public function testgetDescription()
    {

        $Product = new Product();
        $Product->setDescription('Teste');
        $this->assertEquals( $Product->getDescription(), 'Teste');
    }

    public function testPrice()
    {
        $Product = new Product();
        $Product->setPrice(12.5);
        $this->assertEquals( $Product->getPrice(), 12.5 );
    }
}
