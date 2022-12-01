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

    /**
     * @OA\Get(
     *     path="/api/store/readStores.php", tags={"Store"},
     *     @OA\Response(response="200", description="Sucess")
     * )
     */
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

/**
     * @OA\Post(
     *     path="/api/store/create.php", tags={"Store"},
     *     @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(title="Criar Loja", description="", required={"name"}, type="object", 
     *                  @OA\Property(property="name", title="name", type="string", description="name", example="Matriz - São Paulo"),
     *                  @OA\Property(property="address", title="address", type="string", description="address", example="Rua Pedro Vicente, 625"),
     *                  @OA\Property(property="cnpj", title="cnpj", type="string", description="cnpj", example="86146153000167"),
     *                  @OA\Property(property="created", title="created", type="string", description="created", example="2018-06-01 00:35:07"))
     *          )
     *     ),
     *     @OA\Response(response="201", description="Sucess"),
     * )
     */
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

// delete the product

/**
     * @OA\Post(
     *     path="/api/store/delete.php", tags={"Store"},
     *     @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(title="Criar Produto", description="", required={"name"}, type="object", 
     *                  @OA\Property(property="id", title="id", type="string", description="id", example="106"))
     *          )
     *     ),
     *     @OA\Response(response="200", description="Sucess"),
     *     @OA\Response(response="503", description="Object not found"),
     * )
     */
// delete store
function delete(){
  
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
  
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}

// update the product
/**
     * @OA\Put(
     *     path="/api/store/update.php", tags={"Store"},
     *     @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(title="Criar Loja", description="", required={"name"}, type="object", 
     *                  @OA\Property(property="name", title="name", type="string", description="name", example="Matriz - São Paulo"),
     *                  @OA\Property(property="address", title="address", type="string", description="address", example="Rua Pedro Vicente, 625"),
     *                  @OA\Property(property="cnpj", title="cnpj", type="string", description="cnpj", example="86146153000167"),
     *                  @OA\Property(property="created", title="created", type="string", description="created", example="2018-06-01 00:35:07"))
     *          )
     *     ),
     *     @OA\Response(response="200", description="Sucess"),
     *     @OA\Response(response="503", description="Object not found"),
     * )
     */
function update(){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                address = :address,
                cnpj = :cnpj
            WHERE
                id = :id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->address=htmlspecialchars(strip_tags($this->address));
    $this->cnpj=htmlspecialchars(strip_tags($this->cnpj));
    $this->id=htmlspecialchars(strip_tags($this->id));

  
    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':address', $this->address);
    $stmt->bindParam(':cnpj', $this->cnpj);
    $stmt->bindParam(':id', $this->id);

    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}

}

?>