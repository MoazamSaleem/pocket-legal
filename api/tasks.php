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
            $priority = $_GET['priority'] ?? '';
            $search = $_GET['search'] ?? '';
            
            $query = "SELECT t.*, u1.first_name as assigned_first_name, u1.last_name as assigned_last_name, 
                             u2.first_name as created_first_name, u2.last_name as created_last_name,
                             d.title as document_title
                      FROM tasks t 
                      LEFT JOIN users u1 ON t.assigned_to = u1.id 
                      LEFT JOIN users u2 ON t.created_by = u2.id
                      LEFT JOIN documents d ON t.document_id = d.id
                      WHERE 1=1";
            
            $params = [];
            
            if ($status) {
                $query .= " AND t.status = ?";
                $params[] = $status;
            }
            
            if ($priority) {
                $query .= " AND t.priority = ?";
                $params[] = $priority;
            }
            
            if ($search) {
                $query .= " AND (t.title LIKE ? OR t.description LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }
            
            $query .= " ORDER BY t.created_at DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->execute($params);
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode(['success' => true, 'data' => $tasks]);
        }
        break;
        
    case 'POST':
        if ($action === 'create') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $query = "INSERT INTO tasks (title, description, priority, due_date, reminder_date, assigned_to, created_by, document_id, visible_to_company) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                $data['title'],
                $data['description'] ?? null,
                $data['priority'] ?? 'medium',
                $data['due_date'] ?? null,
                $data['reminder_date'] ?? null,
                $data['assigned_to'] ?? $_SESSION['user_id'],
                $_SESSION['user_id'],
                $data['document_id'] ?? null,
                $data['visible_to_company'] ?? true
            ]);
            
            if ($result) {
                $task_id = $conn->lastInsertId();
                echo json_encode([
                    'success' => true, 
                    'message' => 'Task created successfully',
                    'task_id' => $task_id
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create task']);
            }
        }
        break;
        
    case 'PUT':
        if ($action === 'update') {
            $data = json_decode(file_get_contents('php://input'), true);
            $task_id = $_GET['id'] ?? 0;
            
            $query = "UPDATE tasks SET title = ?, description = ?, priority = ?, status = ?, due_date = ?, reminder_date = ?, assigned_to = ? 
                      WHERE id = ?";
            
            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                $data['title'],
                $data['description'],
                $data['priority'],
                $data['status'],
                $data['due_date'],
                $data['reminder_date'],
                $data['assigned_to'],
                $task_id
            ]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Task updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update task']);
            }
        }
        break;
        
    case 'DELETE':
        $task_id = $_GET['id'] ?? 0;
        
        $query = "DELETE FROM tasks WHERE id = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$task_id]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Task deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete task']);
        }
        break;
}
?>