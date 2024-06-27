<?php
include("../patient/Patient.php");
$conn = new mysqli('localhost', 'id22338592_pregnacare', 'Pregna@@00', 'id22338592_pregnacare');
session_start();
$patient = new patient($conn);
if (!isset($_SESSION['user_id'])) {
    // Handle the case when the user is not logged in
    echo "User not logged in";
    exit();
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
    $patient->getPatientsByDoctorId($_SESSION['user_id']);
}
?>