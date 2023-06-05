<?php

namespace App\Repositories;

//require_once '..\autoload.php';




//use App\Config\config;
use PDO;

class Repository{

    private static $instance;
    private $connection;
    
    

    private function __construct($config = null)
    {
        try {


                //if( $this->connection == null){

                    //if( (! isset($config) ) || ($config == '') || (empty($config)) ){

                        $config = '';
                        if(file_exists('Config/config.php')){
                        
                            $config = require_once 'Config/config.php';

                        }elseif(file_exists('App/Config/config.php')){
                            
                            $config = require_once 'App/Config/config.php';
                            
                        }elseif(file_exists('../Config/config.php')){
                            
                            $config = require_once '../Config/config.php';
                        
                        }
                        
                    //}
                 
                    $dsn = $config['driver'].":host=".$config['host'].";"."port=".$config['port'].";"."dbname=".$config['db'];
                    
                    $this->connection = new PDO(
                        $dsn,
                        $config['user'],
                        $config['password'],
                        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                    );
                    
               // }
                 

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new Repository();
        }
        return self::$instance;
    }

    public function getConnection(){
        return $this->connection;
    }

    public function getQuery($sql, $id = null)
    {
        $conn = $this->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchall();
    }

}

//$ProductRepository = new Repository();
//var_dump($ProductRepository->getQuery("SELECT id_product FROM PRODUCT")[0]['id_product']);exit();