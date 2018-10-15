<?php
// include  APIConfigration 

require_once("APIConfigration.php");

class APIDatabase  extends  APIConfigration {
	/*
	 * database configruation informations
	 * set your host , user , password and database name here
	 * */
	private $db_host = "localhost";
	private $db_user = "root";
	private $db_pass = "mysql";
	private $db_name = "hilike";
	public  	$conn = null;
	
	
	function __construct(){
		$this->connect();
	}
	
	
	
	
	public function connect(){
		
		try {
			    $this->conn = new PDO('mysql:host='.$this->db_host.';
			    dbname='.$this->db_name.';charset=utf8', 
			    $this->db_user, $this->db_pass);
	
				    if($this->development_mode && $this->conn != null){
				    //		print("database connected");
				    }
				
				
			} catch (PDOException $e) {
				
				if($this->development_mode){
					print "Error!: " . $e->getMessage() . "<br/>";
			    		
				}else{
					
					echo "Please Contact With Your Webmaster Error:
					 {$this->apierror_catch_database}";	
					
				}
				
			    die();
			}
			
	}
	
	
}
