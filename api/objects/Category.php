<?php
class Category{
  
    // database connection and table name
    private $conn;
    private $table_name = "categories";
  
    // object properties
    public $id;
    public $name;
    public $description;
    public $created;
  
    public function __construct($db){
        $this->conn = $db;
    }
  
    // used by select drop-down list
    public function readAll(){
        //select all data
        $query = "SELECT
                    id, name, description
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name";
  
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
  
        return $stmt;
    }

    // used by select drop-down list
    public function read(){
  
    //select all data
    $query = "SELECT
                id, name, description
            FROM
                " . $this->table_name . "
            ORDER BY
                name";
  
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
  
    return $stmt;
    }


    
/**
     * @OA\Post(
     *     path="/api/category/create.php", tags={"Category"},
     *     @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(title="Criar Categoria", description="", required={"name"}, type="object", 
     *                  @OA\Property(property="name", title="name", type="string", description="name", example="Matriz - São Paulo"),
     *                  @OA\Property(property="description", title="description", type="string", description="description", example="Rua Pedro Vicente, 625"),
     *                  @OA\Property(property="created", title="created", type="string", description="created", example="2018-06-01 00:35:07"))
     *          )
     *     ),
     *     @OA\Response(response="201", description="Sucess"),
     * )
     */
// create category
function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, description=:description, created=:created";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->created=htmlspecialchars(strip_tags($this->created));
  
    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":created", $this->created);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
      
}

// delete the category

/**
     * @OA\Post(
     *     path="/api/category/delete.php", tags={"Category"},
     *     @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(title="Deletar Categoria", description="", required={"name"}, type="object", 
     *                  @OA\Property(property="id", title="id", type="string", description="id", example="1"))
     *          )
     *     ),
     *     @OA\Response(response="200", description="Sucess"),
     *     @OA\Response(response="503", description="Object not found"),
     * )
     */
// delete category
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

// update the category
/**
     * @OA\Put(
     *     path="/api/category/update.php", tags={"Category"},
     *     @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(title="Atualizar Categoria", description="", required={"name"}, type="object", 
     *                  @OA\Property(property="name", title="name", type="string", description="name", example="Categorias esportivos"),
     *                  @OA\Property(property="description", title="description", type="string", description="description", example="Acessórios esportivos em geral"),
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
                description = :description
            WHERE
                id = :id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->id=htmlspecialchars(strip_tags($this->id));

  
    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':id', $this->id);

    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
}
?>