<?php
require_once("MainAliController.php");
/**
 * 
 */
class IndexAliController extends MainAliController {
	
	

	function __construct($param = array()) {
		//$this->connect();
	
		// $users = $this->getAllUsers();
		// $this->response['status'] =  1;
		// $this->response['message'] =  "users list";
		// $this->response['users'] =  $users;
		// echo json_encode($this->response);
		// print_r($param);
		// some proccessing here
		// echo json_encode($this->response);
		
		$res  = array(
			'status' => 200,
			'message' => "api main thread work fine"
		 );
		
		
		echo json_encode($res);
	}
	
// 	
	// private function index(){
		// $users = $this->getAllUsers();
		// $this->response['status'] =  1;
		// $this->response['message'] =  "users list";
		// $this->response['users'] =  $users;
		// return json_encode($this->response);
	// }
// 	
	// private function getAllUsers(){
		// $data = $this->getAll($this->conn, 'user' );
		// //$data = $this->conn->query("SELECT * FROM user")->fetchAll();
		// return $data;
	// }
// 	
	
	
	
}
