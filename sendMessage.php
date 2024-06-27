<?php
session_start(); // Start the session

$conn = new mysqli('localhost', 'id22338592_pregnacare', 'Pregna@@00', 'id22338592_pregnacare');
$input = json_decode(file_get_contents('php://input'), true);

// Function to prepare JSON response with status code
function sendResponse($statusCode, $responseData) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($responseData);
    exit; // Terminate script execution after sending response
}

// Check if the session user ID is set
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the required fields are set in the request body
        if (isset($input['patientId']) && isset($input['messageText'])) {
            // Sanitize the input
            $patientId = htmlspecialchars($input['patientId']);
            $messageText = htmlspecialchars($input['messageText']);
            $senderId = $_SESSION['user_id']; // Retrieve sender ID from session

            // Insert the message into the database
            $stmt = $conn->prepare("
                INSERT INTO messages (sender_id, receiver_id, message_text)
                VALUES (?, ?, ?)
            ");
            $stmt->bind_param("iis",$senderId, $patientId, $messageText);
            $stmt->execute();

            // Check if the message was successfully inserted
            if ($stmt->affected_rows > 0) {
                // Return success response
                sendResponse(200, array('message' => 'Message sent successfully'));
            } else {
                // Return error response
                sendResponse(500, array('error' => 'Failed to send message'));
            }

            // Close the statement
            $stmt->close();
        } else {
            // If required fields are not set in the request body
            sendResponse(400, array('error' => 'Patient ID or message text not provided'));
        }
    } else {
        // If the request method is not POST
        sendResponse(405, array('error' => 'Method Not Allowed'));
    }

?>
