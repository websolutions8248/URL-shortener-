<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['url']) || empty($data['url'])) {
        echo json_encode(['error' => 'URL is required']);
        exit;
    }
    
    $url = filter_var($data['url'], FILTER_SANITIZE_URL);
    
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        echo json_encode(['error' => 'Invalid URL']);
        exit;
    }
    
    // Generate short code
    $shortCode = generateShortCode();
    
    // Set expiry
    $expiryDays = isset($data['expiry']) ? (int)$data['expiry'] : 30;
    $expiryDate = $expiryDays > 0 ? date('Y-m-d H:i:s', strtotime("+$expiryDays days")) : null;
    
    // Custom alias
    if (isset($data['alias']) && !empty($data['alias'])) {
        $shortCode = preg_replace('/[^a-zA-Z0-9-_]/', '', $data['alias']);
    }
    
    // In a real application, save to database
    // For demo purposes, we'll return a mock response
    
    $response = [
        'success' => true,
        'originalUrl' => $url,
        'shortUrl' => 'https://short.url/' . $shortCode,
        'shortCode' => $shortCode,
        'expiryDate' => $expiryDate,
        'createdAt' => date('Y-m-d H:i:s'),
        'clicks' => 0
    ];
    
    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Method not allowed']);
}

function generateShortCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $shortCode = '';
    
    for ($i = 0; $i < $length; $i++) {
        $shortCode .= $characters[rand(0, $charactersLength - 1)];
    }
    
    return $shortCode;
}
?>
