<?php
require_once '../models/user.php';
require_once '../controllers/DBcontroller.php';
class contactcontroller{
    protected $db ;
    
    public function getcontacts($c){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="select * from contacts where userid = '".$c."'";
            $result=$db->select($quary);

            if($result===false){
                echo 'error in quary';
                $db->closeConc();
                return false;

            }
            else{
                if(count($result)==0){
                    $_SESSION["errMsg"]='you have entered wrong email or password';
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
    public function addcontact(contact $c){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="insert into contacts values ('','".$_SESSION["userid"]."','".$c->getphone()."','".$c->getname()."','".$c->getemail()."','".$c->getpphoto()."','')";

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
    public function getContactUser($c){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="select * from users where phone = '".$c."'";
            $result=$db->select($quary);

            if($result===false){
                echo 'error in quary';
                $db->closeConc();
                return false;

            }
            else{
                if(count($result)==0){
                    $_SESSION["errMsg"]='you have entered wrong email or password';
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
    public function getContactinfo($c){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="select * from contacts where phone1 = '".$c."'and userid = '".$_SESSION['userid']."' ";
            $result=$db->select($quary);

            if($result===false){
                echo 'error in quary';
                $db->closeConc();
                return false;

            }
            else{
                $db->closeConc();
                return $result['0'];
            }
        }
        else{
            echo 'error in quary';
                return false;
        }
    }
    public function delete($id){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="delete from contacts where id = '$id'";

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
                return false;
        }
    }
    public function block($id){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="update contacts set blocked = 1 where id = '$id'";

            if($db->update($quary)){
                    
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
                return false;
        }
    }
    public function unblock($id){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="update contacts set blocked = 0 where id = '$id'";

            if($db->update($quary)){
                    
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
                return false;
        }
    }
    public function checkblock($id){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="select * from contacts where phone1 = '{$_SESSION['userphone']}' and userid = '$id'";
            $result=$db->select($quary);
            
            if($result['0']['blocked']){
                    
                    return false;
            }
            else{
                return true;
            }
        }
        else{
            echo 'error in database connection';
                return false;
        }
    }
    public function editprofile(contact $contact){
        $db =new DBcontroller;
        if($db->openConc()){
            
            $quary="update contacts set name = '".$contact->getname()."', 
                                    email ='".$contact->getemail()."',
                                    phone1 = '".$contact->getphone()."',
                                    pphoto = '".$contact->getpphoto()."'
                                    where id = '".$contact->getID()."'";
            if($db->update($quary)){
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
                return false;
        }
    }
}
?>