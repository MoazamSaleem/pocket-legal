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
        
    case 'POST':
        if ($action === 'invite') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            $email = $data['email'] ?? '';
            $role = $data['role'] ?? 'viewer';
            $message = $data['message'] ?? '';
            
            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Invalid email address']);
                exit;
            }
            
            // Check if user already exists
            $query = "SELECT id FROM users WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => false, 'message' => 'User with this email already exists']);
                exit;
            }
            
            // Generate invitation token
            $invitation_token = bin2hex(random_bytes(32));
            
            try {
                // Save invitation
                $query = "INSERT INTO user_invitations (email, role, message, invitation_token, invited_by, status, created_at) VALUES (?, ?, ?, ?, ?, 'pending', NOW())";
                $stmt = $conn->prepare($query);
                $stmt->execute([$email, $role, $message, $invitation_token, $_SESSION['user_id']]);
                
                // Send invitation email (simplified)
                $invitation_url = "http://" . $_SERVER['HTTP_HOST'] . "/register.php?token=" . $invitation_token;
                
                $email_body = "
                    <h2>You're invited to join PocketLegal</h2>
                    <p>Dear User,</p>
                    <p>{$_SESSION['user_name']} has invited you to join their PocketLegal team as a {$role}.</p>
                    " . (!empty($message) ? "<p>Message: {$message}</p>" : "") . "
                    <p><a href='{$invitation_url}' style='background-color: #3B82F6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Accept Invitation</a></p>
                    <p>If the button doesn't work, copy and paste this link: {$invitation_url}</p>
                    <p>Best regards,<br>PocketLegal Team</p>
                ";
                
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: noreply@pocketlegal.com" . "\r\n";
                
                // In production, use proper email service
                mail($email, "Invitation to join PocketLegal", $email_body, $headers);
                
                echo json_encode(['success' => true, 'message' => 'Invitation sent successfully']);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Failed to send invitation: ' . $e->getMessage()]);
            }
        }
        break;
        
    case 'PUT':
        if ($action === 'update') {
            $data = json_decode(file_get_contents('php://input'), true);
            $user_id = $_GET['id'] ?? $_SESSION['user_id'];
            
            // Only allow users to update their own profile or admins to update any profile
            if ($user_id != $_SESSION['user_id'] && $_SESSION['user_role'] !== 'admin') {
                echo json_encode(['success' => false, 'message' => 'Permission denied']);
                exit;
            }
            
            $query = "UPDATE users SET first_name = ?, last_name = ?, phone = ?, company = ?, job_title = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $result = $stmt->execute([
                $data['first_name'],
                $data['last_name'],
                $data['phone'],
                $data['company'],
                $data['job_title'],
                $user_id
            ]);
            
            if ($result) {
                // Update session if user updated their own profile
                if ($user_id == $_SESSION['user_id']) {
                    $_SESSION['user_name'] = $data['first_name'] . ' ' . $data['last_name'];
                    $_SESSION['user_company'] = $data['company'];
                }
                echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
            }
        }
        break;
}
?>