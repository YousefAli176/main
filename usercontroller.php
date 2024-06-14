<?php
class usercontroller{
    protected $db ;
    
    public function getusers($c){
        $db =new DBcontroller;
        if($db->openConc()){
            $quary="select * from users where phone like '".$c."%'";
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

    public function deleteAcc($id){
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
    
    

}
?>