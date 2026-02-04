<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if (isset($_GET['code'])) {
    $shortCode = $_GET['code'];
    
    // In a real application, look up the short code in database
    // For demo, we'll redirect to a default URL
    
    $urls = [
        'demo123' => 'https://example.com',
        'test456' => 'https://google.com'
    ];
    
    if (isset($urls[$shortCode])) {
        // Track analytics
        logClick($shortCode);
        
        // Redirect
        header('Location: ' . $urls[$shortCode]);
        exit;
    } else {
        header('HTTP/1.0 404 Not Found');
        echo 'URL not found';
    }
} else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Short code is required';
}

function logClick($shortCode) {
    // Log click to database or file
    $data = [
        'shortCode' => $shortCode,
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'],
        'userAgent' => $_SERVER['HTTP_USER_AGENT'],
        'referer' => $_SERVER['HTTP_REFERER'] ?? ''
    ];
    
    // In a real app, save to database
    file_put_contents('clicks.log', json_encode($data) . PHP_EOL, FILE_APPEND);
}
?>
