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
            $status = $_GET['status'] ?? '';
            $category = $_GET['category'] ?? '';
            $search = $_GET['search'] ?? '';
            
            $query = "SELECT t.*, u.first_name, u.last_name 
                      FROM templates t 
                      LEFT JOIN users u ON t.user_id = u.id 
                      WHERE t.user_id = ?";
            
            $params = [$_SESSION['user_id']];
            
            if ($status) {
                $query .= " AND t.status = ?";
                $params[] = $status;
            }
            
            if ($category) {
                $query .= " AND t.category = ?";
                $params[] = $category;
            }
            
            if ($search) {
                $query .= " AND (t.name LIKE ? OR t.description LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }
            
            $query .= " ORDER BY t.created_at DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->execute($params);
            $templates = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode(['success' => true, 'data' => $templates]);
        }
        break;
        
    case 'POST':
        if ($action === 'create') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $query = "INSERT INTO templates (name, description, category, content, status, user_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                $data['name'],
                $data['description'] ?? null,
                $data['category'] ?? 'General',
                $data['content'] ?? '',
                $data['status'] ?? 'draft',
                $_SESSION['user_id']
            ]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Template created successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create template']);
            }
        }
        break;
        
    case 'PUT':
        if ($action === 'update') {
            $data = json_decode(file_get_contents('php://input'), true);
            $template_id = $_GET['id'] ?? 0;
            
            $query = "UPDATE templates SET name = ?, description = ?, category = ?, content = ?, status = ? WHERE id = ? AND user_id = ?";
            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                $data['name'],
                $data['description'],
                $data['category'],
                $data['content'],
                $data['status'],
                $template_id,
                $_SESSION['user_id']
            ]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Template updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update template']);
            }
        }
        break;
        
    case 'DELETE':
        $template_id = $_GET['id'] ?? 0;
        
        $query = "DELETE FROM templates WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$template_id, $_SESSION['user_id']]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Template deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete template']);
        }
        break;
}
?>