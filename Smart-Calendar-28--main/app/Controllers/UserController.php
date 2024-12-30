<?php
define('__ROOT__', dirname(__FILE__));

require_once(__ROOT__ . "controller/Controller.php");

class UsersController extends Controller {
    public function insert() {
        $name = $_REQUEST['name']; 
        $email = $_REQUEST['email']; 
        $password = $_REQUEST['password']; 

        $this->model->insertUser($name, $email, $password); 
    }

    public function edit() {
        $id = $_REQUEST['id']; 
        $name = $_REQUEST['name']; 
        $email = $_REQUEST['email']; 
        $password = $_REQUEST['password']; 

        $this->model->editUser($id, $name, $email, $password); 
    }

    public function delete() {
        $id = $_REQUEST['id']; 

        $this->model->deleteUser($id); 
    }
}
