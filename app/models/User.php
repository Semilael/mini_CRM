<?php

class User
{
    private $db;

    public function __construct(){
        $this->db = Database::getInstance()->getConnection();

        try{
            $rersult = $this->db->query("SELECT 1 FROM `users` LIMIT 1");
        } catch (PDOException $e){
            $this->createTable();
        }
    }

    public function createTable(){
        $roleTableQuery ="CREATE TABLE IF NOT EXISTS `roles`(
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `role_name` VARCHAR(255) NOT NULL,
            `role_description` TEXT)";


        $userTableQuery = "CREATE TABLE IF NOT EXISTS `users`(
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `email_verification` TINYINT(1) NOT NULL DEFAULT 0,
            `password` VARCHAR(255) NOT NULL,   
            `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
            `role` INT(11) NOT NULL DEFAULT 0,
            `is_active` TINYINT(1) NOT NULL DEFAULT 1,
            `last_login` TIMESTAMP NULL,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`role`) REFERENCES `roles` (`id`)
        )";

        try{
            $this->db->exec($roleTableQuery);
            $this->db->exec($userTableQuery);
            return true;
        } catch(PDOException $e){
            return false;
        }
    }

    public function getUsers(){
        try{
            $stmt = $this->db->query("SELECT * FROM users");
            $users = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $users[] = $row;
            }
            return $users;
        } catch(PDOException $e){
            return false;
        }
        
    }

    public function create($data)
    {
        
        $username = $data['username'];
        $email = $data['email'];
        $role = $data['role'];
        $password = $data['password'];
        $created_at = date("Y-m-d H:i:s");

        $query = "INSERT INTO users (username, email, role, password, created_at) VALUES(?, ?, ?, ?, ?)";
        try{
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                $username,
                $email,
                $role,
                $password,
                $created_at]);
                return true;
        } catch(PDOException $e){
            return false;
        }
    }

    public function delete($id){
        $query = "DELETE FROM users WHERE id = ?";
        try{
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return true;
        } catch(PDOException $e) {
            return false;
        }
    }

    public function read($id){
        $query = "SELECT * FROM users WHERE id = ?";
        try{
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;

        } catch(PDOException $e) {
            return false;
        }
    }

    public function update($id, $data){
        echo $data;
        var_dump($data);
        $username = $data['username'];
        $email = $data['email'];
        $role = $data['role'];
        $is_active = isset($data['is_active']);
        $is_admin = !empty($data['is_admin']) && $data['is_admin'] !==0 ? 1 : 0;

        $query = "UPDATE users SET username = ?, email = ?, role = ?, is_active = ?, is_admin = ? WHERE id = ?";
        try{
            $stmt = $this->db->prepare($query);
            $stmt->execute([$username,  $email, $role, $is_active, $is_admin, $id]);
            return true;
        }catch(PDOException $e) {
            return false;
        }
    }
}
