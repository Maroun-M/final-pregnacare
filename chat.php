<?php
session_start();

// Create connection
$conn = new mysqli('localhost', 'id22338592_pregnacare', 'Pregna@@00', 'id22338592_pregnacare');

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'error' => "Connection failed: " . $conn->connect_error]));
}

// Handle incoming request
$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'] ?? '';

if ($action === 'send') {
    $senderId = $input['senderId'];
    $receiverId = $input['receiverId'];
    $messageText = $input['messageText'];

    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message_text) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $senderId, $receiverId, $messageText);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'error' => $stmt->error]);
    }

    $stmt->close();
} elseif ($action === 'get') {
    $userId1 = $input['userId1'];
    $userId2 = $input['userId2'];

    $stmt = $conn->prepare("SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp");
    $stmt->bind_param("iiii", $userId1, $userId2, $userId2, $userId1);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $messages = [];

        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }

        echo json_encode($messages);
    } else {
        echo json_encode(['status' => 'error', 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'invalid_action']);
}

$conn->close();
?>
