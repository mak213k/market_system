<?php

namespace Tests;

require_once 'App\autoload.php';

use PHPUnit\Framework\TestCase;
use App\Repositories\Repository;

class RepositoryTest extends TestCase
{
    public function testIdProduct()
    {
        $Repository = new Repository();
        $this->assertEquals( $Repository->getQuery("SELECT id_product FROM PRODUCT")[0]['id_product'], 1);
    }
}