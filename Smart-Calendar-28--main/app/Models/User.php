<?php

class User {
    private $id;
    private $name;
    private $email;
    private $password;

    
    public function __construct($id, $name, $email, $password) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function displayUser() {
        return "ID: $this->id, Name: $this->name, Email: $this->email"; 
}
}