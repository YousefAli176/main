<?php

class notfication{
    private $id;
    private $userid;
    private $content;
    private $seen;

    public function getID(){
        return $this->id;
    }
    public function setID($us){
        $this->id=$us;
    }
    public function getuserID(){
        return $this->userid;
    }
    public function setuserID($us){
        $this->userid=$us;
    }
    public function getcontent(){
        return $this->content;
    }
    public function setcontent($us){
        $this->content=$us;
    }
    public function getseen(){
        return $this->seen;
    }
    public function setseen($us){
        $this->seen=$us;
}
}

?>