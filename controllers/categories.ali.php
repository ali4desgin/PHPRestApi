<?php
require_once("MainAliController.php");
/**
 * 
 */
class CategoriesAliController extends MainAliController {
	
	private $res = array();
	
	function __construct($param = array()) {
		
		$this->connect();
		$this->core($param);
		
	}
	
	
	
	
	
	private function core($param){
		$param_count = count($param);
		if(empty($param) || ($param_count == 1 and empty($param[0]))){
			$this->index();
		}else{
			
			
			//echo $param_count;
			
			if($param_count == 1){
				$id = $param[0];
				$id_checker = $this->checkID($id, "categories");
				// inside main ali controller 
				if(!$id_checker){
					$this->res['status'] = 0;
					$this->res['message'] = "Category id are not valid";
					
				}else{
					
					$this->res['status'] = 1;
					$this->res['message'] = "category ($id) data has been fetched";
					
				}
				
			}else if($param_count == 2){
					$start = $param[0];
					$end = $param[1];
					$this->res['status'] = 1;
					$this->res['message'] = "categories  list from ($start) to ($end)";
					
			}else{
				
			}
			
			
			echo json_encode($this->res);
					
			//$this->index();
		}
	}
	
	
	private function index(){
		$this->res['status'] = 200;
		$this->res['message'] = "categories list";
		$this->res['message_in_arabic'] = "قائمة الاصناف";
		echo  json_encode($this->res);
	}
	
	
	
	
	
	
}
