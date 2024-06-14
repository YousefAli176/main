<?php
require_once '../models/message.php'; 
require_once '../controllers/DBcontroller.php';
class messageController{
    protected $db ;
    
    public function getChat($c){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="select * from message where (userid = '".$c."'and recipientid ='".$_SESSION['contactAsUser']['0']['id']."')or (userid = '".$_SESSION['contactAsUser']['0']['id']."'and recipientid ='".$c."')";
            $result=$db->select($quary);
            $timestamp = array_column($result, 'timestamp');
            array_multisort($timestamp, SORT_ASC, $result);
            
            if($result===false){
                echo 'error in quary';

                $db->closeConc();
                return false;

            }
            else{
                if(count($result)==0){
                    $_SESSION["errMsg"]='there is no messages';
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
                $db->closeConc();
                return false;
        }
    }
    
    public function sendMessage(message $c){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="insert into message values ('','".$_SESSION["userid"]."','".$_SESSION['contactAsUser']['0']['id']."',NOW(),'".$c->getText()."')";

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
    public function delete($id){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="delete from message where id = '$id'";

            if($db->delete($quary)){
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