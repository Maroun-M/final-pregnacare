<?php
session_start();
include_once("./src/doctor/Doctor.php");
$conn = new mysqli('localhost', 'id22338592_pregnacare', 'Pregna@@00', 'id22338592_pregnacare');


$stmt = $conn->prepare("
SELECT u.id, u.first_name, u.last_name, u.profile_picture FROM patients p JOIN patient_doctor pd ON p.patient_id = pd.patient_id JOIN doctors d ON pd.doctor_id = d.doctor_id JOIN users u ON p.user_id = u.id WHERE d.user_id = ?;


");


$stmt->bind_param("i", $_SESSION['user_id']); 
$stmt->execute();
$result = $stmt->get_result();

$patients = [];
while ($row = $result->fetch_assoc()) {
    $patients[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($patients);
?>
