<?php

class call{
    private $id;
    private $callerid;
    private $receiverid;
    private $status;

    private $timeStamp;
    public function getID(){
        return $this->id;
    }
    public function setID($us){
        $this->id=$us;
    }
    public function getcallerID(){
        return $this->callerid;
    }
    public function setcallerID($us){
        $this->callerid=$us;
    }
    public function getreceiverid(){
        return $this->receiverid;
    }
    public function setreceiverid($us){
        $this->receiverid=$us;
    }
    public function getstatus(){
        return $this->status;
    }
    public function setstatus($us){
        $this->status=$us;
    }
    public function gettimeStamp(){
        return $this->timeStamp;
    }
    public function settimeStamp($us){
        $this->timeStamp=$us;
    }

}

?>