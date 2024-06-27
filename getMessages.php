<?php
// Assume you have already established a database connection
session_start();
$conn = new mysqli('localhost', 'id22338592_pregnacare', 'Pregna@@00', 'id22338592_pregnacare');
$input = json_decode(file_get_contents('php://input'), true);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the patientId is set in the request body
    if (isset($input['patientId'])) {
        // Sanitize the patientId
        $patientId = htmlspecialchars($input['patientId']);

        // Initialize arrays for messages sent by the patient and received by the doctor
        $messagesSentByPatient = [];
        $messagesReceivedByDoctor = [];

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("
            SELECT * 
            FROM messages 
            WHERE sender_id = ? AND receiver_id = ?
            ORDER BY timestamp ASC
        ");
        // Bind parameters for messages sent by the patient
        $stmt->bind_param("ii", $patientId, $_SESSION['user_id']);
        $stmt->execute();

        // Fetch the messages sent by the patient
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $messagesSentByPatient[] = $row;
        }

        // Close the statement
        $stmt->close();

        // Use prepared statement for messages received by the doctor
        $stmt = $conn->prepare("
            SELECT * 
            FROM messages 
            WHERE sender_id = ? AND receiver_id = ?
            ORDER BY timestamp ASC
        ");
        // Bind parameters for messages received by the doctor
        $stmt->bind_param("ii", $_SESSION['user_id'], $patientId);
        $stmt->execute();

        // Fetch the messages received by the doctor
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $messagesReceivedByDoctor[] = $row;
        }

        // Close the statement
        $stmt->close();

        // Return the messages as JSON
        header('Content-Type: application/json');
        echo json_encode(array('sentByPatient' => $messagesSentByPatient, 'receivedByDoctor' => $messagesReceivedByDoctor));
    } else {
        // If patientId is not set in the request body
        http_response_code(400);
        echo json_encode(array('error' => 'Patient ID not provided'));
    }
} else {
    // If the request method is not POST
    http_response_code(405);
    echo json_encode(array('error' => 'Method Not Allowed'));
}
?>
