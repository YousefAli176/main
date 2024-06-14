<?php
require_once '../models/user.php';
require_once '../controllers/DBcontroller.php';
class Authcontroller{
    
    public function login(user $c){
        $db =new DBcontroller;
        if($db->openConc()){
            $e=$c->getemail();
            $p=$c->getpassword();

            $quary="select * from users where email = '".$e ."'and password = '".$p."'";
            $result=$db->select($quary);

            if($result===false){
                echo 'error in quary';
                $db->closeConc();
                return false;

            }
            else{
                if(count($result)==0){
                    session_start();
                    $_SESSION["errMsg"]='you have entered wrong email or password';
                    $db->closeConc();
                    return false;
                }
                else if($result[0]["accStatus"]==0){
                    $_SESSION["errMsg"]='Your Account is Suspended!';
                    $db->closeConc();
                    return false;
                }
                else{
                    session_start();
                    $_SESSION["userid"]=$result[0]["id"];
                    $_SESSION["username"]=$result[0]["name"];
                    $_SESSION["userrole"]=$result[0]["roleid"];
                    $_SESSION["useremail"]=$result[0]["email"];
                    $_SESSION["userphone"]=$result[0]["phone"];
                    $_SESSION["userphoto"]=$result[0]["pphoto"];
                    $_SESSION["userpassword"]=$result[0]["password"];
                    $db->closeConc();
                    return true;
                }
            }
        }
        else{
            echo 'error in quary';
                $db->closeConc();
                return false;
        }
    }

    public function register(user $c){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="insert into users values ('','".$c->getusername()."','".$c->getpassword()."','".$c->getphone()."','".$c->getemail()."','dist\img\avatars\ 03-37-26850273_original_1765x3072.jpg',1,1)";
            $result=$db->insert($quary);

            if($result!=false){
                session_start();
                    $_SESSION["userid"]=$result;
                    $_SESSION["username"]=$c->getusername();
                    $_SESSION["userrole"]="1";
                    $_SESSION["useremail"]=$c->getemail();
                    $_SESSION["userphone"]=$c->getphone();
                    $_SESSION["userpassword"]=$c->getpassword();
                    $_SESSION["userphoto"]="dist/img/avatars/avatar-male-1.jpg";
                    $db->closeConc();
                    return true;

            }
            else{
                session_start();
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

    public function editprofile(user $client){
        $db =new DBcontroller;
        if($db->openConc()){
            
            $quary="update users set name = '".$client->getusername()."', 
                                    email ='".$client->getemail()."',
                                    password ='".$client->getpassword()."',
                                    phone = '".$client->getphone()."',
                                    pphoto = '".$client->getpphoto()."'
                                    where id = '".$_SESSION['userid']."'";
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
    public function getNewInfo( $c){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="select * from users where id = '".$c ."'";
            $result=$db->select($quary);

            if($result===false){
                echo 'error in quary';
                $db->closeConc();
                return false;

            }
            else{
                $_SESSION["userid"]=$result[0]["id"];
                $_SESSION["username"]=$result[0]["name"];
                $_SESSION["userrole"]=$result[0]["roleid"];
                $_SESSION["useremail"]=$result[0]["email"];
                $_SESSION["userphone"]=$result[0]["phone"];
                $_SESSION["userphoto"]=$result[0]["pphoto"];
                $_SESSION["userpassword"]=$result[0]["password"];
                $db->closeConc();
                return true;
            }
        }
        else{
            echo 'error in quary';
                $db->closeConc();
                return false;
        }
    }




}
?>