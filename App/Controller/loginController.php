<?php


namespace App\Controller;

use App\Services\loginServices;

class loginController 
{


    public function login($username,$sword)
    {
        $username_consult = "abc";
        $sword_consult = "abc";

        if( ($username  == $username_consult) && ($sword  == $sword_consult) )
        {
            die( json_encode( array( "status"=>true ) ) );
        }

        die( json_encode( array( "status"=>false ) ) );
    }
}

$login = new loginController();
$login->login($_POST['user'],$_POST['pass']);

?>