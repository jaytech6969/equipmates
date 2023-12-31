<?php

require_once 'database.php';

Class customer{
    //attributes

    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $password;


    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    //Methods

    function add(){
        $sql = "INSERT INTO account (firstname, lastname, email, password ) VALUES 
        (:firstname, :lastname, :email, :password);";

        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':firstname', $this->firstname);
        $query->bindParam(':lastname', $this->lastname);
      
        $query->bindParam(':email', $this->email);
        // Hash the password securely using password_hash
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $query->bindParam(':password', $hashedPassword);
        
        if($query->execute()){
            return true;
        }
        else{
            return false;
        }	
    }

    function edit(){
        $sql = "UPDATE staff SET firstname=:firstname, lastname=:lastname, role=:role, email=:email, password=:password, status=:status WHERE id = :id;";

        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':firstname', $this->firstname);
        $query->bindParam(':lastname', $this->lastname);
        $query->bindParam(':role', $this->role);
        $query->bindParam(':email', $this->email);
        // Hash the password securely using password_hash
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        $query->bindParam(':password', $hashedPassword);
        $query->bindParam(':status', $this->status);
        $query->bindParam(':id', $this->id);
        
        if($query->execute()){
            return true;
        }
        else{
            return false;
        }	
    }

    function fetch($record_id){
        $sql = "SELECT * FROM staff WHERE id = :id;";
        $query=$this->db->connect()->prepare($sql);
        $query->bindParam(':id', $record_id);
        if($query->execute()){
            $data = $query->fetch();
        }
        return $data;
    }

    function show(){
        $sql = "SELECT * FROM staff ORDER BY firstname ASC, lastname ASC;";
        $query=$this->db->connect()->prepare($sql);
        $data = null;
        if($query->execute()){
            $data = $query->fetchAll();
        }
        return $data;
    }
}

?>