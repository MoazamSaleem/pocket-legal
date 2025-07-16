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
            $query = "SELECT t.*, u.first_name, u.last_name, 
                             (SELECT COUNT(*) FROM team_members tm WHERE tm.team_id = t.id) as member_count
                      FROM teams t 
                      LEFT JOIN users u ON t.created_by = u.id 
                      ORDER BY t.created_at DESC";
            
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode(['success' => true, 'data' => $teams]);
        }
        break;
        
    case 'POST':
        if ($action === 'create') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            try {
                $conn->beginTransaction();
                
                // Create team
                $query = "INSERT INTO teams (name, description, created_by, created_at) VALUES (?, ?, ?, NOW())";
                $stmt = $conn->prepare($query);
                $stmt->execute([
                    $data['name'],
                    $data['description'] ?? null,
                    $_SESSION['user_id']
                ]);
                
                $team_id = $conn->lastInsertId();
                
                // Add creator as team admin
                $query = "INSERT INTO team_members (team_id, user_id, role, added_by, added_at) VALUES (?, ?, 'admin', ?, NOW())";
                $stmt = $conn->prepare($query);
                $stmt->execute([$team_id, $_SESSION['user_id'], $_SESSION['user_id']]);
                
                $conn->commit();
                
                echo json_encode(['success' => true, 'message' => 'Team created successfully', 'team_id' => $team_id]);
            } catch (Exception $e) {
                $conn->rollBack();
                echo json_encode(['success' => false, 'message' => 'Failed to create team: ' . $e->getMessage()]);
            }
        }
        break;
        
    case 'DELETE':
        $team_id = $_GET['id'] ?? 0;
        
        try {
            $conn->beginTransaction();
            
            // Check if user is team admin
            $query = "SELECT * FROM team_members WHERE team_id = ? AND user_id = ? AND role = 'admin'";
            $stmt = $conn->prepare($query);
            $stmt->execute([$team_id, $_SESSION['user_id']]);
            
            if ($stmt->rowCount() === 0) {
                echo json_encode(['success' => false, 'message' => 'You do not have permission to delete this team']);
                exit;
            }
            
            // Delete team members
            $query = "DELETE FROM team_members WHERE team_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$team_id]);
            
            // Delete team
            $query = "DELETE FROM teams WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$team_id]);
            
            $conn->commit();
            
            echo json_encode(['success' => true, 'message' => 'Team deleted successfully']);
        } catch (Exception $e) {
            $conn->rollBack();
            echo json_encode(['success' => false, 'message' => 'Failed to delete team: ' . $e->getMessage()]);
        }
        break;
}
?>