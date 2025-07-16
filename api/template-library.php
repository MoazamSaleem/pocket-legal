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
            $category = $_GET['category'] ?? '';
            $search = $_GET['search'] ?? '';
            
            $query = "SELECT t.*, u.first_name, u.last_name 
                      FROM templates t 
                      LEFT JOIN users u ON t.user_id = u.id 
                      WHERE t.status = 'published'";
            
            $params = [];
            
            if ($category) {
                $query .= " AND t.category = ?";
                $params[] = $category;
            }
            
            if ($search) {
                $query .= " AND (t.name LIKE ? OR t.description LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }
            
            $query .= " ORDER BY t.rating DESC, t.created_at DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->execute($params);
            $templates = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode(['success' => true, 'data' => $templates]);
        }
        break;
        
    case 'POST':
        if ($action === 'use') {
            $template_id = $_POST['template_id'] ?? 0;
            $title = $_POST['title'] ?? '';
            
            // Get template
            $query = "SELECT * FROM templates WHERE id = ? AND status = 'published'";
            $stmt = $conn->prepare($query);
            $stmt->execute([$template_id]);
            $template = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$template) {
                echo json_encode(['success' => false, 'message' => 'Template not found']);
                exit;
            }
            
            // Create new document from template
            $query = "INSERT INTO documents (title, description, file_name, file_path, file_size, file_type, user_id, status, document_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            
            // Create a temporary file with template content
            $temp_file = tempnam(sys_get_temp_dir(), 'template_');
            file_put_contents($temp_file, $template['content']);
            
            $result = $stmt->execute([
                $title ?: $template['name'],
                'Created from template: ' . $template['name'],
                $template['name'] . '.txt',
                $temp_file,
                strlen($template['content']),
                'text/plain',
                $_SESSION['user_id'],
                'draft',
                'contract'
            ]);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Document created from template successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create document from template']);
            }
        }
        break;
}
?>