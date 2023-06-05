<?php

namespace App\autoload;





//use Config\config;

class Autoload {
    public function __construct() {
        spl_autoload_extensions('.php');
        spl_autoload_register(array($this, 'load'));
    
    }
    private function load($className) {

        $className = substr( 
            str_replace("\\",
            "/",$className),4,
            strlen(str_replace("\\","/",$className)) 
        );
        
        $extension = spl_autoload_extensions();
        require_once ( $className . $extension);
    }
}

$autoload = new Autoload();
