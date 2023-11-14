<?php

class AuthUser
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
    public function register($username, $email, $password)
{
    $created_at = date('Y-m-d H:i:s');
    $role = 1;

    $query = "INSERT INTO users (username, email, password, created_at, role) VALUES (?, ?, ?, ?, ?)";

    try {
        $stmt = $this->db->prepare($query);
        $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $created_at, $role]);
        return true;
    } catch (PDOException $e) {
        echo "Registration error: " . $e->getMessage();
        return false;
    }
}


    public function login($email, $password)
    {
        $query = "SELECT * FROM users WHERE email = ? LIMIT 1";

        try{

            $stmt = $this->db->prepare($query);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        } catch(PDOException $e){
            return false;
        }
    }

    public function findUserByEmail($email){

        $query = "SELECT * FROM users WHERE email = ? LIMIT 1";

        try{
            $stmt = $this->db->prepare($query);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ? $user : false;
        } catch(PDOException $e) {
            return false;
        }
    }

}
