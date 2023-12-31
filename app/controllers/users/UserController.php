<?php
require_once 'app/models/User.php';
require_once 'app/models/roles/Role.php';


class UsersController{
    public function index(){
        $userModel = new User();
        $users = $userModel->getUsers();

        include 'app/views/users/index.php';
    }

    public function create(){
        include 'app/views/users/create.php';
    }

    public function store(){
        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['email']) ) {
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if($password !== $confirm_password) {
                echo "Passwords do not match";
                return;
            }
            $userModel = new User();
            //$config = require_once __DIR__ . '/../../../config.php';
            $data = [
                'username' => $_POST['username'],  
                'email' => $_POST['email'],
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' =>  1, //$config['start_role'], // Default value for user role
            ];
            $userModel->create($data);
        } 
        header('Location: index.php?page=users');

    }

    public function edit(){
        $userModel = new User();
        $user = $userModel->read($_GET['id']);

        $roleModel = new Role();
        $roles = $roleModel->getAllRoles();
        var_dump($roles, $user);
        include 'app/views/users/edit.php';
    }

    public function update(){
        $userModel = new User();
        $userModel->update($_GET['id'], $_POST);

        header('Location: index.php?page=users');
    }
    
    public function delete(){
        $userModel = new User();
        $userModel->delete($_GET['id']);

        header('Location: index.php?page=users');
    }
}