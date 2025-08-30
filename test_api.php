<?php

/**
 * Simple test script for the Student Registration API
 * Run this script to test the API endpoint
 */

$baseUrl = 'http://localhost:8000';
$endpoint = '/api/students/register';

// Test data
$testData = [
    'username' => 'test_student',
    'phoneNumber' => '+1234567890'
];

echo "Testing Student Registration API\n";
echo "===============================\n\n";

// Test 1: Valid registration
echo "Test 1: Valid Student Registration\n";
echo "----------------------------------\n";
$response = makeRequest($baseUrl . $endpoint, $testData);
echo "Status Code: " . $response['status'] . "\n";
echo "Response: " . $response['body'] . "\n\n";

// Test 2: Invalid data (missing username)
echo "Test 2: Invalid Data (Missing Username)\n";
echo "--------------------------------------\n";
$invalidData = [
    'phoneNumber' => '+1234567890'
];
$response = makeRequest($baseUrl . $endpoint, $invalidData);
echo "Status Code: " . $response['status'] . "\n";
echo "Response: " . $response['body'] . "\n\n";

// Test 3: Invalid phone number format
echo "Test 3: Invalid Phone Number Format\n";
echo "-----------------------------------\n";
$invalidPhoneData = [
    'username' => 'test_student_2',
    'phoneNumber' => 'invalid_phone'
];
$response = makeRequest($baseUrl . $endpoint, $invalidPhoneData);
echo "Status Code: " . $response['status'] . "\n";
echo "Response: " . $response['body'] . "\n\n";

function makeRequest($url, $data) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_error($ch)) {
        $response = json_encode(['error' => 'cURL Error: ' . curl_error($ch)]);
    }
    
    curl_close($ch);
    
    return [
        'status' => $httpCode,
        'body' => $response
    ];
}

echo "Testing completed!\n";
echo "Make sure your Symfony server is running on http://localhost:8000\n";
