<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $id;
    public $name;
    public $city;
    public $pno;
    public $username;
    public $password;
    public $created;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // signup user
    function signup(){
        if($this->isAlreadyExist()){
            return false;
        }

        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                username=:username, password=:password, name=:name, city=:city, pno=:pno, created=:created";

        $stmt = $this->conn->prepare($query);
        
        // sanitize
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->city=htmlspecialchars(strip_tags($this->city));
        $this->pno=htmlspecialchars(strip_tags($this->pno));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":pno", $this->pno);
        $stmt->bindParam(":created", $this->created);
    
        if($stmt->execute()){
         $this->id = $this->conn->lastInsertId();
         return true;
        }
        return false;
        
    }
    // login user
    function login(){
        // select all query
        $query = "SELECT
                    `id`, `username`, `password`, `created`
                FROM
                    " . $this->table_name . " 
                WHERE
                    username='".$this->username."' AND password='".$this->password."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    function isAlreadyExist(){
        $query = "SELECT *
            FROM
                " . $this->table_name . " 
            WHERE
                username='".$this->username."'";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}
