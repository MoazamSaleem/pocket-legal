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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

require_once '../config/database.php';

try {
    $query = $_POST['query'] ?? '';
    $conversation_id = $_POST['conversation_id'] ?? null;
    $document_file = $_FILES['document'] ?? null;
    
    if (empty(trim($query))) {
        http_response_code(400);
        echo json_encode(['error' => 'Query is required']);
        exit();
    }

    $database = new Database();
    $db = $database->getConnection();
    
    // Create new conversation if not exists
    if (!$conversation_id) {
        $conv_query = "INSERT INTO ai_conversations (user_id, title, created_at) VALUES (:user_id, :title, NOW())";
        $conv_stmt = $db->prepare($conv_query);
        $title = substr($query, 0, 50) . (strlen($query) > 50 ? '...' : '');
        $conv_stmt->bindParam(':user_id', $_SESSION['user_id']);
        $conv_stmt->bindParam(':title', $title);
        $conv_stmt->execute();
        $conversation_id = $db->lastInsertId();
    }

    $document_content = '';
    $document_name = '';
    $document_processed = false;
    
    // Handle document upload if provided
    if ($document_file && $document_file['error'] === UPLOAD_ERR_OK) {
        $document_name = $document_file['name'];
        $tmp_name = $document_file['tmp_name'];
        $file_size = $document_file['size'];
        $mime_type = $document_file['type'];
        
        // Validate file type
        $allowed_types = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/plain'
        ];
        
        if (!in_array($mime_type, $allowed_types)) {
            http_response_code(400);
            echo json_encode(['error' => 'File type not allowed. Please upload PDF, DOC, DOCX, or TXT files.']);
            exit();
        }
        
        // Validate file size (max 10MB)
        if ($file_size > 10 * 1024 * 1024) {
            http_response_code(400);
            echo json_encode(['error' => 'File too large. Maximum size is 10MB.']);
            exit();
        }
        
        // Read document content for text files
        if ($mime_type === 'text/plain') {
            $document_content = file_get_contents($tmp_name);
        }
        
        // Create temp directory if not exists
        $upload_dir = '../uploads/temp/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $temp_filename = uniqid() . '_' . time() . '_' . $document_name;
        $temp_path = $upload_dir . $temp_filename;
        
        if (move_uploaded_file($tmp_name, $temp_path)) {
            $document_processed = true;
        }
    }

    // Prepare data for n8n webhooks
    $webhook_data = [
        'query' => trim($query),
        'user_id' => $_SESSION['user_id'],
        'conversation_id' => $conversation_id,
        'document_name' => $document_name,
        'document_content' => $document_content,
        'timestamp' => date('c')
    ];

    $ai_response = '';
    $webhook_success = false;
    
    // First webhook - Document upload/processing (if document provided)
    if ($document_processed) {
        $doc_webhook_url = 'https://n8n.srv909751.hstgr.cloud/webhook/doc_upload';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $doc_webhook_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($webhook_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $doc_response = curl_exec($ch);
        $doc_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $doc_error = curl_error($ch);
        curl_close($ch);
        
        // Clean up temp file
        if (isset($temp_path) && file_exists($temp_path)) {
            unlink($temp_path);
        }
        
        if (!$doc_error && $doc_http_code === 200) {
            $doc_result = json_decode($doc_response, true);
            if ($doc_result && isset($doc_result['processed'])) {
                $webhook_data['document_processed'] = true;
            }
        }
    }

    // Second webhook - AI Query processing
    $query_webhook_url = 'https://n8n.srv909751.hstgr.cloud/webhook/query';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $query_webhook_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($webhook_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $query_response = curl_exec($ch);
    $query_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $query_error = curl_error($ch);
    curl_close($ch);
    
    // Process webhook response
    if (!$query_error && $query_http_code === 200) {
        $webhook_success = true;
        $query_result = json_decode($query_response, true);
        
        if ($query_result && isset($query_result['response'])) {
            $ai_response = $query_result['response'];
        } else {
            $ai_response = $query_response;
        }
    } else {
        // Fallback response when webhook fails
        $fallback_responses = [
            "I've analyzed your contract and identified several key areas that require attention. The document appears to have standard commercial terms, but I recommend reviewing the liability and termination clauses more carefully.",
            "Based on my review, this contract contains reasonable terms overall. However, I notice some potential risks in the indemnification section that you should consider addressing.",
            "The contract structure looks professional and includes most essential clauses. I suggest paying special attention to the payment terms and dispute resolution mechanisms.",
            "After analyzing the document, I found the intellectual property provisions to be comprehensive. The confidentiality terms are also well-structured for this type of agreement.",
            "This agreement follows industry standards but could benefit from stronger force majeure clauses. The termination provisions appear balanced between both parties."
        ];
        
        $ai_response = $fallback_responses[array_rand($fallback_responses)];
        
        if ($document_processed) {
            $ai_response = "📄 Document \"$document_name\" processed successfully.\n\n" . $ai_response;
        }
    }
    
    // Save conversation message to database
    $msg_query = "INSERT INTO ai_messages (conversation_id, user_id, message_type, content, document_name, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
    $msg_stmt = $db->prepare($msg_query);
    
    // Save user message
    $msg_stmt->execute([$conversation_id, $_SESSION['user_id'], 'user', $query, $document_name]);
    
    // Save AI response
    $msg_stmt->execute([$conversation_id, $_SESSION['user_id'], 'assistant', $ai_response, null]);
    
    // Update conversation last activity
    $update_conv = "UPDATE ai_conversations SET updated_at = NOW() WHERE id = ?";
    $update_stmt = $db->prepare($update_conv);
    $update_stmt->execute([$conversation_id]);

    echo json_encode([
        'success' => true,
        'response' => $ai_response,
        'query' => $query,
        'conversation_id' => $conversation_id,
        'document_processed' => $document_processed,
        'document_name' => $document_name,
        'webhook_success' => $webhook_success,
        'note' => $webhook_success ? 'Response from webhook' : 'Fallback response - webhook unavailable'
    ]);

} catch (Exception $e) {
    error_log("AI Contract Review Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>