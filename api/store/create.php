<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database/Database.php';

// instantiate store object
include_once '../objects/Store.php';
  
$database = new Database();
$db = $database->getConnection();
  
$store = new Store($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->address) &&
    !empty($data->cnpj)
){
  
    // set store property values
    $store->name = $data->name;
    $store->address = $data->address;
    $store->cnpj = $data->cnpj;
    $store->created = date('Y-m-d H:i:s');
  
    // create the store
    if($store->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "store was created."));
    }
  
    // if unable to create the store, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create store."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create store. Data is incomplete."));
}
?>