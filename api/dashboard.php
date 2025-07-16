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
        if ($action === 'stats') {
            $stats = [];
            
            // Total documents
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM documents WHERE user_id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $stats['documents'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            
            // Total tasks
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tasks WHERE assigned_to = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $stats['tasks'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            
            // Completed tasks
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tasks WHERE assigned_to = ? AND status = 'completed'");
            $stmt->execute([$_SESSION['user_id']]);
            $stats['completed_tasks'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            
            // Pending tasks
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tasks WHERE assigned_to = ? AND status IN ('todo', 'in_progress')");
            $stmt->execute([$_SESSION['user_id']]);
            $stats['pending_tasks'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            
            // Recent documents
            $stmt = $conn->prepare("SELECT * FROM documents WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
            $stmt->execute([$_SESSION['user_id']]);
            $stats['recent_documents'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Recent tasks
            $stmt = $conn->prepare("SELECT * FROM tasks WHERE assigned_to = ? ORDER BY created_at DESC LIMIT 5");
            $stmt->execute([$_SESSION['user_id']]);
            $stats['recent_tasks'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode(['success' => true, 'data' => $stats]);
        }
        break;
}
?>