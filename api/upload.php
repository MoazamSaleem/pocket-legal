<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

require_once '../config/database.php';
require_once '../classes/Document.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

try {
    $database = new Database();
    $db = $database->getConnection();
    $document = new Document($db);

    $upload_dir = '../uploads/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $uploaded_files = [];
    $errors = [];

    if (isset($_FILES['documents'])) {
        $files = $_FILES['documents'];
        
        // Handle multiple files
        if (is_array($files['name'])) {
            $file_count = count($files['name']);
            
            for ($i = 0; $i < $file_count; $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $original_name = $files['name'][$i];
                    $tmp_name = $files['tmp_name'][$i];
                    $file_size = $files['size'][$i];
                    $mime_type = $files['type'][$i];
                    
                    // Validate file type
                    $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain'];
                    if (!in_array($mime_type, $allowed_types)) {
                        $errors[] = "File type not allowed for {$original_name}";
                        continue;
                    }
                    
                    // Validate file size (max 10MB)
                    if ($file_size > 10 * 1024 * 1024) {
                        $errors[] = "File too large: {$original_name}";
                        continue;
                    }
                    
                    // Generate unique filename
                    $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);
                    $filename = uniqid() . '_' . time() . '.' . $file_extension;
                    $file_path = $upload_dir . $filename;
                    
                    if (move_uploaded_file($tmp_name, $file_path)) {
                        // Save to database
                        $document->user_id = $_SESSION['user_id'];
                        $document->filename = $filename;
                        $document->original_name = $original_name;
                        $document->file_path = $file_path;
                        $document->file_size = $file_size;
                        $document->mime_type = $mime_type;
                        $document->status = 'uploaded';
                        
                        if ($document->create()) {
                            $uploaded_files[] = [
                                'id' => $document->id,
                                'filename' => $filename,
                                'original_name' => $original_name,
                                'size' => $file_size
                            ];
                            
                            // Send to webhook for processing (optional)
                            try {
                                $webhook_data = [
                                    'document_id' => $document->id,
                                    'filename' => $original_name,
                                    'user_id' => $_SESSION['user_id'],
                                    'timestamp' => date('c')
                                ];
                                
                                $webhook_url = 'https://n8n.srv909751.hstgr.cloud/webhook/doc_upload';
                                
                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_URL, $webhook_url);
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($webhook_data));
                                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                
                                curl_exec($ch);
                                curl_close($ch);
                            } catch (Exception $e) {
                                // Webhook failed, but file upload succeeded
                                error_log("Webhook failed: " . $e->getMessage());
                            }
                        } else {
                            $errors[] = "Failed to save {$original_name} to database";
                        }
                    } else {
                        $errors[] = "Failed to upload {$original_name}";
                    }
                } else {
                    $errors[] = "Upload error for {$files['name'][$i]}";
                }
            }
        } else {
            // Single file
            if ($files['error'] === UPLOAD_ERR_OK) {
                $original_name = $files['name'];
                $tmp_name = $files['tmp_name'];
                $file_size = $files['size'];
                $mime_type = $files['type'];
                
                // Validate file type
                $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain'];
                if (!in_array($mime_type, $allowed_types)) {
                    $errors[] = "File type not allowed for {$original_name}";
                } else if ($file_size > 10 * 1024 * 1024) {
                    $errors[] = "File too large: {$original_name}";
                } else {
                $file_extension = pathinfo($original_name, PATHINFO_EXTENSION);
                $filename = uniqid() . '_' . time() . '.' . $file_extension;
                $file_path = $upload_dir . $filename;
                
                if (move_uploaded_file($tmp_name, $file_path)) {
                    $document->user_id = $_SESSION['user_id'];
                    $document->filename = $filename;
                    $document->original_name = $original_name;
                    $document->file_path = $file_path;
                    $document->file_size = $file_size;
                    $document->mime_type = $mime_type;
                    $document->status = 'uploaded';
                    
                    if ($document->create()) {
                        $uploaded_files[] = [
                            'id' => $document->id,
                            'filename' => $filename,
                            'original_name' => $original_name,
                            'size' => $file_size
                        ];
                    } else {
                        $errors[] = "Failed to save {$original_name} to database";
                    }
                }
                } else {
                    $errors[] = "Failed to upload {$original_name}";
                }
            }
        }
    }


    echo json_encode([
        'success' => true,
        'uploaded_files' => $uploaded_files,
        'errors' => $errors,
        'message' => count($uploaded_files) . ' file(s) uploaded successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>