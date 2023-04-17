<?php 
include_once("./Patient.php");
session_start();
$conn = new mysqli('localhost', 'root', 'password', 'Ouvatech');
$patient = new Patient($conn);
echo $_SESSION['user_id'];
// Set patient's user ID
if(isset($_POST["dob"]) && isset($_POST["location"]) && isset($_POST["previous-pregnancies"]) && isset($_POST["pregnancy-stage"]) ){
    if(!$patient->checkID($_SESSION['user_id'])){
        $patient->setUserId();
        
    }
    echo $_POST["previous-pregnancies"];
    $patient->setDateOfBirth($_POST["dob"]);
    $patient->setLocation($_POST["location"]);
    $patient->setPreviousPregnancies($_POST["previous-pregnancies"]);
    $patient->setPregnancyStage($_POST["pregnancy-stage"]);
}

if(isset($_POST["diabetics"])){
    $patient->setDiabetic(1);
} else {
    $patient->setDiabetic(0);
}
if(isset($_POST["hypertension"])){
    $patient->setHypertension(1);
} else {
    $patient->setHypertension(0);
}

?>