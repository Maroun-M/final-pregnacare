<?php include_once("./Patient.php");
session_start();
$conn = new mysqli('localhost', 'root', 'password', 'Ouvatech');
$patient = new Patient($conn);


if(isset($_POST["heart-rate"]) && isset($_POST["systolic"]) && isset($_POST["diastolic"])){
    $patient->insert_hr_bp($_POST["heart-rate"], $_POST["systolic"], $_POST["diastolic"], $_SESSION["user_id"]);
    echo $_POST["heart-rate"] ."\n";
    echo $_POST["systolic"]."\n";
    echo $_POST["diastolic"]."\n";
    echo $_SESSION["user_id"]."\n";
}

?>