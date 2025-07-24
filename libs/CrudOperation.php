<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath."/../config/config.php");

/*
	This CrudOperation class is design for CRUD operation
*/
Class CrudOperation{
	 public $host   = DB_HOST;
	 public $user   = DB_USER;
	 public $pass   = DB_PASS;
	 public $dbname = DB_NAME;
	 
	 public $link;
         public $error;
	 
         public function __construct(){
          $this->connectDB();
         }

         public function isConnected(){
                return ($this->link instanceof mysqli);
         }
	 
       private function connectDB(){
                try {
                        mysqli_report(MYSQLI_REPORT_OFF);
                        $this->link = @new mysqli($this->host, $this->user, $this->pass,$this->dbname);
                        if ($this->link->connect_errno) {
                                $this->error = "Connection fail: ".$this->link->connect_error;
                                $this->link = null;
                                return false;
                        }
                } catch (\mysqli_sql_exception $e) {
                        $this->error = "Connection fail: ".$e->getMessage();
                        $this->link = null;
                        return false;
                }
       }
	 
       // Select or Read data
       public function select($query){
                if(!$this->link){
                        return false;
                }
                $result = $this->link->query($query);
                if($result && $result->num_rows > 0){
                        return $result;
                }else {
                        return false;
                }
        }
 
       // Insert data
       public function insert($query){
                if(!$this->link){
                        return false;
                }
                $insert_row = $this->link->query($query);
                if($insert_row){
                        return $insert_row;
                } else {
                        return false;
                }
        }
	  
        // Update data
         public function update($query){
                if(!$this->link){
                        return false;
                }
                $update_row = $this->link->query($query);
                if($update_row){
                        return $update_row;
                } else {
                        return false;
                }
         }
	  
        // Delete data
         public function delete($query){
                if(!$this->link){
                        return false;
                }
                $delete_row = $this->link->query($query);
                if($delete_row){
                        return $delete_row;
                }else{
                        return false;
                }
         }

 //end of Crud Operation class 
}
