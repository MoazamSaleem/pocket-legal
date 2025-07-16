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
            $type = $_GET['type'] ?? '';
            $search = $_GET['search'] ?? '';
            $folder_id = $_GET['folder_id'] ?? '';
            
            $query = "SELECT d.*, f.name as folder_name, u.first_name, u.last_name 
                      FROM documents d 
                      LEFT JOIN folders f ON d.folder_id = f.id 
                      LEFT JOIN users u ON d.user_id = u.id 
                      WHERE 1=1";
            
            $params = [];
            
            if ($status) {
                $query .= " AND d.status = ?";
                $params[] = $status;
            }
            
            if ($type) {
                $query .= " AND d.document_type = ?";
                $params[] = $type;
            }
            
            if ($search) {
                $query .= " AND (d.title LIKE ? OR d.description LIKE ?)";
                $params[] = "%$search%";
                $params[] = "%$search%";
            }
            
            if ($folder_id) {
                $query .= " AND d.folder_id = ?";
                $params[] = $folder_id;
            }
            
            $query .= " ORDER BY d.created_at DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->execute($params);
            $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode(['success' => true, 'data' => $documents]);
        }
        break;
        
    case 'POST':
        if ($action === 'upload') {
            if (isset($_FILES['file'])) {
                $file = $_FILES['file'];
                $upload_dir = '../uploads/documents/';
                
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                $file_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($file['tmp_name'], $file_path)) {
                    $query = "INSERT INTO documents (title, file_name, file_path, file_size, file_type, folder_id, user_id, status, document_type) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    
                    $stmt = $conn->prepare($query);
                    $result = $stmt->execute([
                        $_POST['title'] ?? pathinfo($file['name'], PATHINFO_FILENAME),
                        $file['name'],
                        $file_path,
                        $file['size'],
                        $file['type'],
                        $_POST['folder_id'] ?? null,
                        $_SESSION['user_id'],
                        $_POST['status'] ?? 'draft',
                        $_POST['document_type'] ?? 'contract'
                    ]);
                    
                    if ($result) {
                        echo json_encode(['success' => true, 'message' => 'Document uploaded successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Failed to save document info']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
                }
            }
        }
        break;
        
    case 'DELETE':
        $document_id = $_GET['id'] ?? 0;
        
        // Get file path before deleting
        $query = "SELECT file_path FROM documents WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$document_id, $_SESSION['user_id']]);
        $document = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($document) {
            // Delete from database
            $query = "DELETE FROM documents WHERE id = ? AND user_id = ?";
            $stmt = $conn->prepare($query);
            $result = $stmt->execute([$document_id, $_SESSION['user_id']]);
            
            if ($result) {
                // Delete physical file
                if (file_exists($document['file_path'])) {
                    unlink($document['file_path']);
                }
                echo json_encode(['success' => true, 'message' => 'Document deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete document']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Document not found']);
        }
        break;
}
?>