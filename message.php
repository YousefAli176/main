<?php 

 class message{
    private $id;

    private $text;
    private $timestamp;
    
    public function getID(){
        return $this->id;
    }

    public function setID($us){
        $this->id=$us;
    }

    public function getText(){
        return $this->text;
    }

    public function setText($us){
        $this->text=$us;
    }
    public function getTimestamp(){
        return $this->timestamp;
    }
    public function setTimestamp($p){
        $this->timestamp=$p;
    }
}

?>