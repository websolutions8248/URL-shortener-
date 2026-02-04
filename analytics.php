<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $shortCode = $_GET['code'] ?? null;
    
    // In a real application, fetch from database
    // For demo, return mock data
    
    $analytics = [
        'totalClicks' => 150,
        'uniqueVisitors' => 120,
        'clicksByDay' => [
            '2024-01-01' => 10,
            '2024-01-02' => 15,
            '2024-01-03' => 20,
            '2024-01-04' => 25,
            '2024-01-05' => 30,
            '2024-01-06' => 25,
            '2024-01-07' => 25,
        ],
        'topReferrers' => [
            'Direct' => 50,
            'Google' => 40,
            'Facebook' => 30,
            'Twitter' => 20,
            'Other' => 10
        ],
        'geoData' => [
            'US' => 60,
            'UK' => 30,
            'CA' => 20,
            'AU' => 15,
            'Other' => 25
        ]
    ];
    
    echo json_encode($analytics);
} else {
    echo json_encode(['error' => 'Method not allowed']);
}
?>
