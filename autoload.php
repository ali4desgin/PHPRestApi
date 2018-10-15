<?php
$time_start = microtime(true);
header("content-type: application/json");
header('Access-Control-Allow-Origin: *');
require_once("configuration/APIDatabase.php");
require_once("route/APIRoute.php");
$db = new APIDatabase(); // database connection and configurations
$apiroute = new APIRoute(); //  every thing about route here


$apiroute->parse("",['GET']); // empty for all , ['POST','GET']
$apiroute->parse("categories",['POST','GET']);
$apiroute->parse("route",['POST','GET']);




$result = array(
	"status" => 0,
	"message" => "this route aren't availabe"
);
// // 
// // $time_end = microtime(true);
// // $time = $time_end - $time_start;
// // echo json_encode(array("time"=>$time));


echo json_encode($result);
