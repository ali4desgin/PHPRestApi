<?php
class APIRoute  {
	
	private $route_starter = 4;// put the postion of the main roue from your path
	private $allow_request_methods = array(); // will content all allow reuest method
	private $request_method = null; // put the current rquest method here 
	private $is_allow_request_method = true; //  store if the current request method are allow for this route or not
	
	private $result = array(); // any error result her (will be encoded to json) 
	
	
	
	private $salt_auth = "sdlkcnds78Y367VDHJB0njdn"; // used as authorization key in header 
	
	/*
	 * repsent all params after route
	 * like /home/32/43
	 * this are will get 32,43
	 *
	 * */
	private $params = array(); // repsent all params after route 
	
	
	
	/* evey proccess goes here 
	 * the main route function to proccess and manage everythig
	 * 3 optinal param 
	 * 1 = load_route => the route your want to load like "category"
	 * (you should make file with same name ended with .ali.php inside  controllers folder 
	 * like home.ali.php
	 * and this file must content class with name HomeAliController 
	 * and the class must extends MainAliController
	 * 
	 *  )
	 * */
	public function parse( $load_route = "", $allow_request_methods = array(),$check_auth = false)
	{

		// check if authorization mode are required for this route
		if($check_auth){
			// if auth mode required then get all headers
			$headers = $this->getHeaders();
			
			// check the "apiauthorationkeyfromaliabdalla" value
			if($headers["apiauthorationkeyfromaliabdalla"]!=$this->salt_auth){
				
				// print error it is not valid requestb
				$this->result = array(
					"status" => 0,
					"message" => "request auth fail"
				);
				echo json_encode($this->result);
				
				// exit from the programm
				exit();
			}
		}
		
		// get the current route  like https://example.com/api/home/main/3
		// this will return api/home/main/3
		$route  =  urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
		// explode the current route like api , home , main , 3
		$explode = $this->explode_route($route);
		
		// get the route and the rest will be params 
		$current_route = $explode[$this->route_starter];
		
		// get all params 
		$this->params = array_slice($explode, $this->route_starter + 1); // slice all params
		if($load_route == $current_route) {
			
			// make request to check allow method
			$this->_AllowMethods($allow_request_methods);
			if($this->is_allow_request_method){
				
				if($load_route == ""){
					$load_con = "index";
				}else{
					$load_con = $load_route;
				}
				$this->loadController($load_con);
				
				
			}else{
				$this->result = array(
					"status" => 0,
					"message" => "($this->request_method)request method aren't allow for this route"
				);
				echo json_encode($this->result);
			
				
			}
		
			exit();
			return ;
			
		}
		

		return ;
		
		
		
	}
	
	
	private function getHeaders(){
		// get all headers repsented with the current request	
		return getallheaders(); 
		// return array of  header keys and values
	}
	
	
	private function loadController($controller){
		
		// load controller from controllers folder its should be at this example :: controller.ali.php
		$path = "./controllers/".$controller.".ali.php";
		if(is_file($path)){
			require_once($path);	
			
			// make the first char captial like ali : Ali
			$con = ucfirst($controller);
			
			// init object from class witch it should be inside the controller the class name should be
			// like this ::  IndexAliController and it will extends MainAliController Class 
			$class_name = $con."AliController";
			
			// path paramters with the url to the construct method 
			$obj = new $class_name($this->params);
		
		}else{
			// there is no any controller for this route inside controllers 	 folder 
			$this->result = array(
					"status" => 0,
					"message" => "controller aren't available"
				);
			// print the error in json format
			echo json_encode($this->result);
		}
		
	}
	
	
	
	private function explode_route($route)
	{
		
		// explode the current url and fetch paths 
		return explode("/",$route);
		
		// return something like this : home ,  users ,  1 , 2
	}
	
	
	// this function will tell you if the current request method are allowed or not
	/*
	 * it so cool to spacifc methods for your route 
	 *  feel free to pass the method in carly pracktes like this 
	 * 	['GET','POST'] this will allow get and post request and will deined the reset  
	 * */
    private  function _AllowMethods($allow_request_methods){
    		
    		// ask getRequestMethod function to return the current request menthod
        $this->request_method =  $this->getRequestMethod();

		// check if the pass value where array 
        if(is_array($allow_request_methods)){
        		// put it in  allow_request_methods variable
            $this->allow_request_methods = $allow_request_methods;
            
        }else if(is_string($allow_request_methods)){
            	
            $array = explode(",",$allow_request_methods);
            $this->allow_request_methods = $array;
        }


	
		// if allow_request_methods is empty that mean all methods are allowed then any method will work
        if($this->allow_request_methods!=[]){

			// will make condition between the current request method and the allowed request method
             if(in_array($this->request_method,$this->allow_request_methods)) {

				// if it is true request are allowed
				$this->is_allow_request_method = true;
               // echo "Method Allow " . $this->request_method;
            }else{
    				
				$this->is_allow_request_method = false;
                //echo $this->request_method." Are Not Allowed";
            }
        }else{

			// ALL ARE ALLOWED
            $this->is_allow_request_method = true;
			//echo "allow all";
        }
        

    }
	
	
	
	
	private function getRequestMethod(){
		
		// return the current request method 
		return $_SERVER["REQUEST_METHOD"];
	}
	
}
