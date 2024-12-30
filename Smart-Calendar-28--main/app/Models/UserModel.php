<?php
require_once(__ROOT__ . "model/Model.php");
require_once(__ROOT__ . "model/User.php");

class UserModel extends Model {
    private $users;
    
    function __construct() {
        $this->users = array();
        $this->db = $this->connect();
        $this->fillArray();
    }

    function fillArray() {
        $this->users = array(); 
        $result = $this->readUsers();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                array_push($this->users, new User(
                    $row["ID"], 
                    $row["Name"], 
                    $row["Email"], 
                    $row["Password"], 
                ));
            }
        }
    }

    function getUsers() {
        return $this->users;
    }

    function readUsers() {
        $sql = "SELECT * FROM user";
        $result = $this->db->query($sql);
        return ($result && $result->num_rows > 0) ? $result : false;
    }

    function insertUser($name, $email, $password) {
        
        $hashedPassword = md5($password);

        $sql = "INSERT INTO user (Name, Password, Age, Phone) VALUES ('$name', '$email', '$hashedPassword')";
        if ($this->db->query($sql) === true) {
            echo "User inserted successfully. Auto-incremented ID: " . $this->db->insert_id;
            $this->fillArray(); 
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
        }
    }
}