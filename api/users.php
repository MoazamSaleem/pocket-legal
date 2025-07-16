<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

$auth = new Auth();
$auth->requireLogin();

$database = new Database();
$conn = $database->getConnection();

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch ($method) {
    case 'GET':
        if ($action === 'list') {
            $role = $_GET['role'] ?? '';
            $search = $_GET['search'] ?? '';
            
            $query = "SELECT id, first_name, last_name, email, role, status, company, job_title, created_at FROM users WHERE 1=1";
            $params = [];
            
            if ($role) {
                $query .= " AND role = ?";
                $params[] = $role;
            }
            
            if ($search) {
                $query .= " AND (first_name LIKE ? OR last_name LIKE ? OR email LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }
            
            $query .= " ORDER BY created_at DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->execute($params);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode(['success' => true, 'data' => $users]);
        }
        break;
}
?>