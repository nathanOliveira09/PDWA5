<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database/Database.php';
include_once '../objects/Store.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare store object
$store = new Store($db);
  
// get id of store to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of store to be edited
$store->id = $data->id;
  
// set store property values
$store->name = $data->name;
$store->address = $data->address;
$store->cnpj = $data->cnpj;
  
// update the store
if($store->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Store was updated."));
}
  
// if unable to update the store, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update store."));
}
?>