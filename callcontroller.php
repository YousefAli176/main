<?php

require_once '../models/call.php'; 
require_once '../controllers/DBcontroller.php';
class callcontroller{

public function call(call $c){
    $db =new DBcontroller;
    if($db->openConc()){
        
        $quary="insert into calls values ('','".$c->getID()."','".$c->getreceiverid()."',NOW(),'".$c->getstatus()."')";
        
        if($db->insert($quary)){
                $db->closeConc();
                return true;
        }
        else{
            $_SESSION["errMsg"]='Something went wronge... try again ';
            $db->closeConc();
            return false;
        }
    }
    else{
        echo 'error in database connection';
            //$db->closeConc();
            return false;
    }

}

public function getcall($c){
    $db =new DBcontroller;
    if($db->openConc()){
        $quary="select * from calls where recipientId = '".$c."'";
        $result=$db->select($quary);

        if($result===false){
            echo 'error in quary';
            $db->closeConc();
            return false;

        }
        else{
            if(count($result)==0){
                $_SESSION["errMsg"]='no call log';
                $db->closeConc();
                return false;
            }
            else{
                
                return $result;
            }
        }
    }
    else{
        echo 'error in quary';
           // $db->closeConc();
            return false;
    }
}

}

?>