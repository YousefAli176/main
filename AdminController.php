<?php
require_once '../models/user.php';
require_once '../controllers/DBcontroller.php';
class AdminController{
    protected $db ;
    
    public function getUsers(){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="select * from users";
            $result=$db->select($quary);

            if($result===false){
                echo 'error in quary';
                $db->closeConc();
                return false;

            }
            else{
                if(count($result)==0){
                    $_SESSION["errMsg"]='Wrong';
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


    public function userCount(){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="SELECT COUNT(*) FROM users;";
            $result=$db->select($quary);

            if($result===false){
                echo 'error in quary';
                $db->closeConc();
                return false;

            }
            else{
                if(count($result)==0){
                    $_SESSION["errMsg"]='Wrong';
                    $db->closeConc();
                    return false;
                }
                else{
                    // print_r($result);
                    return $result[0]["COUNT(*)"];
                }
            }
        }
        else{
            echo 'error in quary';
                $db->closeConc();
                return false;
        }


    }

    public function messageCount(){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="SELECT COUNT(*) FROM message;";
            $result=$db->select($quary);

            if($result===false){
                echo 'error in quary';
                $db->closeConc();
                return false;

            }
            else{
                if(count($result)==0){
                    $_SESSION["errMsg"]='Wrong';
                    $db->closeConc();
                    return false;
                }
                else{
                    // print_r($result);
                    return $result[0]["COUNT(*)"];
                }
            }
        }
        else{
            echo 'error in quary';
                $db->closeConc();
                return false;
        }


    }

    public function contactCount(){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="SELECT COUNT(*) FROM contacts;";
            $result=$db->select($quary);

            if($result===false){
                echo 'error in quary';
                $db->closeConc();
                return false;

            }
            else{
                if(count($result)==0){
                    $_SESSION["errMsg"]='Wrong';
                    $db->closeConc();
                    return false;
                }
                else{
                    // print_r($result);
                    return $result[0]["COUNT(*)"];
                }
            }
        }
        else{
            echo 'error in quary';
                $db->closeConc();
                return false;
        }


    }

    public function delete($id){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="delete from users where id = '$id'";

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
    public function suspende($id){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="update users set accStatus = 0 where id = '$id'";

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
    public function unsuspende($id){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="update users set accStatus = 1 where id = '$id'";

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

    public function AddAdmin(user $c){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="insert into users values ('','".$c->getusername()."','".$c->getpassword()."','".$c->getphone()."','".$c->getemail()."','dist\img\avatars\ 03-37-26850273_original_1765x3072.jpg',2,1)";
            $result=$db->insert($quary);

            if($result==false){
                session_start();
                $_SESSION["errMsg"]='Something went wronge... try again ';
                $db->closeConc();
                return true;

            }
            else{

                $db->closeConc();
                return true;
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