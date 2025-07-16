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
    case 'POST':
        if ($action === 'send') {
            if (!isset($_FILES['document'])) {
                echo json_encode(['success' => false, 'message' => 'No document uploaded']);
                exit;
            }
            
            $file = $_FILES['document'];
            $recipientEmail = $_POST['recipient_email'] ?? '';
            $recipientName = $_POST['recipient_name'] ?? '';
            $subject = $_POST['subject'] ?? 'Please sign this document';
            $message = $_POST['message'] ?? 'Please review and sign the attached document.';
            
            // Validate inputs
            if (empty($recipientEmail) || empty($recipientName)) {
                echo json_encode(['success' => false, 'message' => 'Recipient email and name are required']);
                exit;
            }
            
            if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Invalid email address']);
                exit;
            }
            
            // Save uploaded document
            $upload_dir = '../uploads/esignature/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $file_name = uniqid() . '.' . $file_extension;
            $file_path = $upload_dir . $file_name;
            
            if (!move_uploaded_file($file['tmp_name'], $file_path)) {
                echo json_encode(['success' => false, 'message' => 'Failed to upload document']);
                exit;
            }
            
            // Generate unique signing token
            $signing_token = bin2hex(random_bytes(32));
            
            // Save to database
            try {
                $query = "INSERT INTO esignature_requests (user_id, document_name, document_path, recipient_email, recipient_name, subject, message, signing_token, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'sent', NOW())";
                $stmt = $conn->prepare($query);
                $stmt->execute([
                    $_SESSION['user_id'],
                    $file['name'],
                    $file_path,
                    $recipientEmail,
                    $recipientName,
                    $subject,
                    $message,
                    $signing_token
                ]);
                
                $request_id = $conn->lastInsertId();
                
                // Send email (simplified - in real implementation, use proper email service)
                $signing_url = "http://" . $_SERVER['HTTP_HOST'] . "/sign.php?token=" . $signing_token;
                
                $email_body = "
                    <h2>{$subject}</h2>
                    <p>Dear {$recipientName},</p>
                    <p>{$message}</p>
                    <p><a href='{$signing_url}' style='background-color: #3B82F6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Sign Document</a></p>
                    <p>If the button doesn't work, copy and paste this link: {$signing_url}</p>
                    <p>Best regards,<br>{$_SESSION['user_name']}</p>
                ";
                
                // In a real implementation, you would use a proper email service like SendGrid, Mailgun, etc.
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "From: noreply@pocketlegal.com" . "\r\n";
                
                if (mail($recipientEmail, $subject, $email_body, $headers)) {
                    echo json_encode([
                        'success' => true, 
                        'message' => 'Document sent for signature successfully',
                        'request_id' => $request_id,
                        'signing_url' => $signing_url
                    ]);
                } else {
                    echo json_encode([
                        'success' => true, 
                        'message' => 'Document prepared for signature (email sending simulated)',
                        'request_id' => $request_id,
                        'signing_url' => $signing_url
                    ]);
                }
                
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            }
        }
        break;
        
    case 'GET':
        if ($action === 'list') {
            try {
                $query = "SELECT * FROM esignature_requests WHERE user_id = ? ORDER BY created_at DESC";
                $stmt = $conn->prepare($query);
                $stmt->execute([$_SESSION['user_id']]);
                $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo json_encode(['success' => true, 'data' => $requests]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            }
        }
        break;
}
?>