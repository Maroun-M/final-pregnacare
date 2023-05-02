<?php
// Establish database connection
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'root', 'password', 'ouvatech');
session_start();
// Check if the blood-glucose parameter exists in the GET request
// Get the user ID from the GET request
$user_id = $_SESSION['user_id'];

// Default time range is 7 days
$time_range = '-7 days';

// Check if a time range is specified in the GET request
if(isset($_GET['option'])) {
    $range = $_GET['option'];
    switch($range) {
        case 'weekly':
            $time_range = '-7 days';
            break;
        case 'monthly':
            $time_range = '-1 month';
            break;
        case 'yearly':
            $time_range = '-1 year';
            break;
        default:
            // Invalid range specified, default to 7 days
            $time_range = '-7 days';
    }
}
$timestamp = strtotime($time_range);
$timestamp = date('Y-m-d', $timestamp);
$current_time = date('Y-m-d');

// Select the blood glucose data for the specified time range
$query = "SELECT glucose_level, timestamp FROM blood_glucose WHERE user_id = $user_id AND DATE(timestamp) BETWEEN '$timestamp' AND '$current_time'";
$result = $conn->query($query);

// Create an array to hold the data
$data = array();

// Loop through the results and add the data to the array
while ($row = $result->fetch_assoc()) {
  $data[] = array(
    'glucose_level' => $row['glucose_level'],
    'timestamp' => date('Y-m-d ', strtotime($row['timestamp']))
  );
}

// Send the data as JSON
echo json_encode($data);
?>
