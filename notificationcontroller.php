<?php

require_once '../models/notification.php'; 
require_once '../controllers/DBcontroller.php';

class notificationcontroller{

 
    public function getNotification($c){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="select * from notification  where userid = '".$c."'";
            $result=$db->select($quary);
            $timestamp = array_column($result, 'timestamp');
            array_multisort($timestamp, SORT_DESC, $result);
            if($result===false){
                echo 'error in quary';
                $db->closeConc();
                return false;

            }
            else{
                if(count($result)==0){
                    $_SESSION["errMsg"]='no notification';
                    $db->closeConc();
                    return false;
                }
                else{
                    
                    return $result;
                }
            }
        }
        else{
            echo 'no connection';
            // $db->closeConc();
                return false;
        }
}
    
public function addnotification(notfication $c){
    $db =new DBcontroller;
    if($db->openConc()){
        $quary="insert into notification values ('','{$c->getcontent()}','{$c->getseen()}','{$c->getuserID()}',NOW())";

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
            $db->closeConc();
            return false;
    }
}
}

?>