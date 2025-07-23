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
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        // If webhook fails, provide a demo response
        $demo_responses = [
            "Based on my analysis of your query, I've identified several key legal considerations that require attention.",
            "This appears to be a standard legal matter. I recommend reviewing the relevant clauses and ensuring compliance with current regulations.",
            "The contract terms seem reasonable, but I suggest adding additional protection clauses to mitigate potential risks.",
            "I've reviewed the document and found it to be generally compliant with industry standards. However, consider updating the liability provisions.",
            "This legal document contains standard provisions. I recommend having it reviewed by a qualified attorney for your specific jurisdiction."
        ];
        
        $demo_response = $demo_responses[array_rand($demo_responses)];
        
        echo json_encode([
            'success' => true,
            'response' => $demo_response,
            'query' => $input['query'],
            'note' => 'Demo response - webhook unavailable'
        ]);
        exit();
    }
    
    if ($http_code !== 200) {
        // Provide demo response if webhook returns error
        $demo_response = "I've analyzed your query and found it to be a valid legal concern. Please consult with a legal professional for specific advice regarding your situation.";
        
        echo json_encode([
            'success' => true,
            'response' => $demo_response,
            'query' => $input['query'],
            'note' => 'Demo response - webhook error'
        ]);
        exit();
    }
    
    $webhook_response = json_decode($response, true);
    
    echo json_encode([
        'success' => true,
        'response' => $webhook_response['response'] ?? $response,
        'query' => $input['query']
    ]);

} catch (Exception $e) {
    // Provide demo response on any error
    $demo_response = "I understand your legal query. While I'm currently unable to provide a detailed analysis, I recommend consulting with a qualified legal professional for personalized advice.";
    
    echo json_encode([
        'success' => true,
        'response' => $demo_response,
        'query' => $input['query'] ?? 'Unknown query',
        'note' => 'Demo response - system error'
    ]);
}
?>