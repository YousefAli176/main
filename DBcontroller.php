<?php
/**
 * Summary of DBcontroller
 */
class DBcontroller{
    public $dbHost ='localhost';
    public $dbUser='root';
    public $dbName='test';
    public $dbPassord='';

    public $connection;
    public function openConc()
    {

        $this->connection =new mysqli($this->dbHost,$this->dbUser,$this->dbPassord,$this->dbName);
        if($this->connection->connect_error){
            echo "error in conction";
            return false;
        }
        else{
            return true;
        }
    }
    public function closeConc()
    {

        if($this->connection){
            $this->connection->close();
        }
        else{
            echo 'conction is aleardy closed';
        }
    }

    public function select($qry){
        
        $result=$this->connection->query($qry);
        if(!$result){
            echo 'error: '.mysqli_error($this->connection);
            return false;
        }
        else{
            return $result->fetch_all(MYSQLI_ASSOC);
            
        }
    }
    public function insert($qry){
        
        $result=$this->connection->query($qry);
        if(!$result){
            echo 'error: '.mysqli_error($this->connection);
            return false;
        }
        else{
            return $this->connection->insert_id;

        }
    }
    public function delete($qry){
        
        $result=$this->connection->query($qry);
        if(!$result){
            echo 'error: '.mysqli_error($this->connection);
            return false;
        }
        else{
            return true;

        }
    }
    public function update($qry){
        
        $result=$this->connection->query($qry);
        if(!$result){
            echo 'error: '.mysqli_error($this->connection);
            return false;
        }
        else{
            return $result;

        }
    }

    
    
}
?>