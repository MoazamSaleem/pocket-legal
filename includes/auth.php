<?php
session_start();
require_once __DIR__ . '/../config/database.php';

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
        // Check if email already exists
        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$data['email']]);
        
        if ($stmt->rowCount() > 0) {
            return false; // Email already exists
        }
        
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
            // Check if we're in an API call
            if (strpos($_SERVER['REQUEST_URI'], '/api/') !== false) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Authentication required']);
            } else {
                header("Location: login.php");
            }
            exit();
        }
    }
}
?>