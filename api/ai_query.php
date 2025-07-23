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

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['query']) || empty(trim($input['query']))) {
        http_response_code(400);
        echo json_encode(['error' => 'Query is required']);
        exit();
    }

    $webhook_data = [
        'query' => trim($input['query']),
        'user_id' => $_SESSION['user_id'],
        'timestamp' => date('c')
    ];

    $webhook_url = 'https://n8n.srv909751.hstgr.cloud/webhook/query';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $webhook_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($webhook_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        throw new Exception("Webhook request failed: " . $error);
    }
    
    if ($http_code !== 200) {
        throw new Exception("Webhook returned HTTP " . $http_code);
    }
    
    $webhook_response = json_decode($response, true);
    
    echo json_encode([
        'success' => true,
        'response' => $webhook_response['response'] ?? $response,
        'query' => $input['query']
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>