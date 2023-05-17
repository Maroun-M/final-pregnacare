<?php
include("../patient/Patient.php");
$conn = new mysqli('localhost', 'root', 'password', 'Ouvatech');
session_start();
$patient = new patient($conn);
if($_SERVER["REQUEST_METHOD"] == "GET"){
    $patient->getPatientsByDoctorId($_SESSION['user_id']);
}
?>