<?php
    require_once 'user.php';
    require_once 'authenticator.php';
    class admin extends User implements authenticator{
        public $role;
        public function __construct($r)
        {
            $this->role=$r;
        }
        public function login($us, $pass){

        }
        public function logout(){
            
        }

    }


?>