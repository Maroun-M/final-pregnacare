<?php 
include("../patient/Patient.php");
$conn = new mysqli('localhost', 'root', 'password', 'Ouvatech');
session_start();
$patient = new Patient($conn);
if(isset($_GET['patient'])){
    $patient->getPatientPregnancyStage($_SESSION['user_id']);
}
?>