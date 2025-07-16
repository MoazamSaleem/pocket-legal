<?php
require_once '../includes/auth.php';
require_once '../config/database.php';

$auth = new Auth();
$auth->requireLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['file'])) {
        echo json_encode(['success' => false, 'message' => 'No file uploaded']);
        exit;
    }
    
    $file = $_FILES['file'];
    $question = $_POST['question'] ?? '';
    
    // Validate file type
    $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain'];
    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type. Please upload PDF, DOC, DOCX, or TXT files.']);
        exit;
    }
    
    // Read file content (simplified - in real implementation, you'd use proper document parsing)
    $content = '';
    if ($file['type'] === 'text/plain') {
        $content = file_get_contents($file['tmp_name']);
    } else {
        // For demo purposes, we'll simulate document content
        $content = "This is a sample contract content for AI review demonstration.";
    }
    
    // Simulate AI analysis (in real implementation, you'd integrate with OpenAI, Claude, etc.)
    $aiResponse = [
        'summary' => 'This document appears to be a standard service agreement with typical terms and conditions. The contract includes payment terms, deliverables, and termination clauses.',
        'issues' => [
            'Payment terms are not clearly defined with specific dates',
            'Liability limitations may be too broad',
            'Termination clause lacks notice period specification',
            'Intellectual property ownership needs clarification'
        ],
        'recommendations' => [
            'Add specific payment due dates (e.g., Net 30)',
            'Include mutual liability caps',
            'Specify 30-day notice period for termination',
            'Clearly define work product ownership',
            'Add dispute resolution mechanism'
        ]
    ];
    
    // If user asked a specific question, provide a targeted response
    if (!empty($question)) {
        $aiResponse['question_response'] = "Based on your question: '{$question}', I recommend reviewing the specific clauses mentioned in the issues above. The document would benefit from more precise language in the areas you've inquired about.";
    }
    
    // Log the AI review for audit purposes
    try {
        $database = new Database();
        $conn = $database->getConnection();
        
        $query = "INSERT INTO ai_reviews (user_id, file_name, question, response, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->execute([
            $_SESSION['user_id'],
            $file['name'],
            $question,
            json_encode($aiResponse)
        ]);
    } catch (Exception $e) {
        // Continue even if logging fails
        error_log("Failed to log AI review: " . $e->getMessage());
    }
    
    echo json_encode(['success' => true, 'data' => $aiResponse]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>