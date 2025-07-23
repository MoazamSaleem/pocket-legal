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