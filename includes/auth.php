<?php
session_start();
require_once 'config/database.php';

class Auth {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function login($email, $password) {
        $query = "SELECT id, first_name, last_name, email, password, role, company, job_title, avatar FROM users WHERE email = ? AND status = 'active'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_company'] = $user['company'];
                $_SESSION['user_avatar'] = $user['avatar'];
                return true;
            }
        }
        return false;
    }
    
    public function register($data) {
        $query = "INSERT INTO users (first_name, last_name, email, password, phone, company, job_title) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        
        try {
            $stmt->execute([
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $hashed_password,
                $data['phone'] ?? null,
                $data['company'] ?? null,
                $data['job_title'] ?? null
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function logout() {
        session_destroy();
        header("Location: login.php");
        exit();
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header("Location: login.php");
            exit();
        }
    }
}
?>