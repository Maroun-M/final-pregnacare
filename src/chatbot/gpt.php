<?php
header('Content-Type: application/json');

// Log the received POST data
$request_body = file_get_contents('php://input');

// Decode the JSON data, if applicable
$post_data = json_decode($request_body, true);

// Check if the 'message' input is provided
if (empty($post_data['message'])) {
    echo json_encode(['error' => 'No message provided']);
    exit();
} 

// Retrieve the message from the input
$user_message = $post_data['message'];

// Replace with your actual API key

// Prepare the data for the API request
$data = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'system', 'content' => 'This chatbot specializes in health and pregnancy topics. Feel free to ask any questions related to health, pregnancy, childbirth, and maternity.'],
        ['role' => 'user', 'content' => $user_message]
    ],
    'max_tokens' => 150
];


// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ],
    CURLOPT_SSL_VERIFYPEER => false, // Disable SSL verification
    CURLOPT_SSL_VERIFYHOST => false, // Disable SSL host verification
]);

// Execute the cURL request
$result = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    // Include the contents of $post_data in the error message
    $postContents = print_r($post_data, true);
    echo json_encode(['reply' => 'Error: ' . curl_error($ch), 'post_data' => $postContents]);
} else {
    // Decode the JSON response
    $response = json_decode($result, true);

    // Check for API errors
    if (isset($response['error'])) {
        echo json_encode(['reply' => 'API Error: ' . $response['error']['message']]);
    } else {
        // Extract and output the bot's response
        $reply = $response['choices'][0]['message']['content'];
        echo json_encode(['reply' => trim($reply)]);
    }
}

// Close cURL session
curl_close($ch);
?>
