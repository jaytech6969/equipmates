<?php

require_once 'database.php';

Class Product{
    //attributes

    public $id;
    public $pizzaname;
    public $category;
    public $price;
    public $availability;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    //Methods

    function add(){
        $sql = "INSERT INTO product (pizzaname, category, price, availability) VALUES 
        (:pizzaname, :category, :price, :availability);";

        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':pizzaname', $this->pizzaname);
        $query->bindParam(':category', $this->category);
        $query->bindParam(':price', $this->price);     
        $query->bindParam(':availability', $this->availability);
        // Hash the password securely using password_hash
        // $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        // $query->bindParam(':password', $hashedPassword);
        // $query->bindParam(':availability', $this->availability);
        
        if($query->execute()){
            return true;
        }
        else{
            return false;
        }	
    }

    function edit(){
        $sql = "UPDATE product SET pizzaname=:pizzaname, category=:category, price=:price, availability=:availability WHERE id = :id;";

        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':pizzaname', $this->pizzaname);
        $query->bindParam(':category', $this->category);
             
        $query->bindParam(':price', $this->price);
        $query->bindParam(':availability', $this->availability);
        $query->bindParam(':id', $this->id);
        
        if($query->execute()){
            return true;
        }
        else{
            return false;
        }	
    }

    function fetch($record_id){
        $sql = "SELECT * FROM product WHERE id = :id;";
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':id', $record_id);
        if($query->execute()){
            $data = $query->fetch();
        }
        return $data;
    }

    function show(){
        $sql = "SELECT * FROM product ORDER BY pizzaname ASC;";
        $query=$this->db->connect()->prepare($sql);
        $data = null;
        if($query->execute()){
            $data = $query->fetchAll();
        }
        return $data;
    }

    function is_pizzaname_exist(){
        $sql = "SELECT * FROM product WHERE pizzaname = :pizzaname;";
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':pizzaname', $this->pizzaname);
        if($query->execute()){
            if($query->rowCount()>0){
                return true;
            }
        }
        return false;
    }
}

?>