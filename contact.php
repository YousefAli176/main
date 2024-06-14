<?php 

 class contact{
    private $id;
    private $name;

    private $pphoto;

    private $phone;

    private $email;

    private $timestamp;

    private $status;

    public function getID(){
        return $this->id;
    }

    public function setID($us){
        $this->id=$us;
    }
    public function getname(){
        return $this->name;
    }

    public function setname($us){
        $this->name=$us;
    }

    public function getemail(){
        return $this->email;
    }

    public function setemail($us){
        $this->email=$us;
    }
    public function getpphoto(){
        return $this->pphoto;
    }
    public function setpphoto($p){
        $this->pphoto=$p;
    }
    public function getphone(){
        return $this->phone;
    }
    public function setphone($p){
        $this->phone=$p;
    }
    public function getphone1(){
        return $this->phone;
    }
    public function setphone1($p){
        $this->phone=$p;
    }
    public function getTimeStamp(){
        return $this->timestamp;
    }
    public function setTimeStamp($p){
        $this->timestamp=$p;
    }
    public function getStatus(){
        return $this->status;
    }
    public function setStatus($p){
        $this->status=$p;
    }
}

?>