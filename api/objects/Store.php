<?php

Class Store{

    private $conn;
    private $table_name = "stores";

    public $id;
    public $name;
    public $address;
    public $cnpj;
    public $created;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read stores
    function read(){
  
    // select all query
    $query = "SELECT
                 s.id, s.name, s.address, s.cnpj, s.created
            FROM
                " . $this->table_name . " s
            ORDER BY
                s.created DESC";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
  
    return $stmt;
}

// create store
function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, address=:address, cnpj=:cnpj, created=:created";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->address=htmlspecialchars(strip_tags($this->address));
    $this->cnpj=htmlspecialchars(strip_tags($this->cnpj));
    $this->created=htmlspecialchars(strip_tags($this->created));
  
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":address", $this->address);
    $stmt->bindParam(":cnpj", $this->cnpj);
    $stmt->bindParam(":created", $this->created);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}

}

?>