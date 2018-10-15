<?php
require_once("./configuration/APIDatabase.php");
//  
 // //**
 // * 
 // */
class MainAliController extends APIDatabase {
	protected $response = array();
	protected $header = array();

	

	protected function checkID($id, $table){
		if(!is_numeric($id)){
			return false;
		}
		
		
		return true;
	}
	
	public function getAll($conn, $table ){
		$query = $conn->query("SELECT * FROM {$table}");
		$result = json_encode($query->fetchAll());
		return $result;
	}
}
