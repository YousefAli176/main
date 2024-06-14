<?php
    require_once 'user.php';
    class user{
        private $id;

        private $username;
        private $password;

        private $email;

        private $role;
        private $pphoto;
        private $phone;




        public function getusername(){
            return $this->username;
        }
        public function getpassword(){
            return $this->password;
        }
        public function getid(){
            return $this->id;
        }
        public function setid($pw){
            $this->id=$pw;
        }

        public function setusername($us){
            $this->username=$us;
        }
        public function setpassword($pw){
            $this->password=$pw;
        }
        public function getemail(){
            return $this->email;
        }
        public function setemail($e){
            $this->email=$e;
        }

        public function getrole(){
            return $this->role;
        }
        public function setrole($r){
            $this->role=$r;
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
    }
?>