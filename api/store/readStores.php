<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// database connection will be here
// include database and object files
include_once '../config/database/Database.php';
include_once '../objects/Store.php';
  
// instantiate database and store object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$store = new Store($db);
  
// read stores will be here

// query stores
$stmt = $store->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // stores array
    $stores_arr=array();
    $stores_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $store_item=array(
            "id" => $id,
            "name" => $name,
            "address" => html_entity_decode($address),
            "cnpj" => $cnpj,
            "created" => $created,
        );
  
        array_push($stores_arr["records"], $store_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show stores data in json format
    $itens = json_encode($stores_arr);
    echo $itens;
    //echo json_encode($stores_arr);
}