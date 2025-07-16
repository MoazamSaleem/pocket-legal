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
            $query = "SELECT f.*, COUNT(d.id) as document_count 
                      FROM folders f 
                      LEFT JOIN documents d ON f.id = d.folder_id 
                      GROUP BY f.id 
                      ORDER BY f.created_at DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $folders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode(['success' => true, 'data' => $folders]);
        }
        break;
        
    case 'POST':
        if ($action === 'create') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $query = "INSERT INTO folders (name, description, color, parent_id, user_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                $data['name'],
                $data['description'] ?? null,
                $data['color'] ?? '#3B82F6',
                $data['parent_id'] ?? null,
                $_SESSION['user_id']
            ]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Folder created successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create folder']);
            }
        }
        break;
        
    case 'PUT':
        if ($action === 'update') {
            $data = json_decode(file_get_contents('php://input'), true);
            $folder_id = $_GET['id'] ?? 0;
            
            $query = "UPDATE folders SET name = ?, description = ?, color = ? WHERE id = ? AND user_id = ?";
            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                $data['name'],
                $data['description'],
                $data['color'],
                $folder_id,
                $_SESSION['user_id']
            ]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Folder updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update folder']);
            }
        }
        break;
        
    case 'DELETE':
        $folder_id = $_GET['id'] ?? 0;
        
        $query = "DELETE FROM folders WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        $result = $stmt->execute([$folder_id, $_SESSION['user_id']]);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Folder deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete folder']);
        }
        break;
}
?>