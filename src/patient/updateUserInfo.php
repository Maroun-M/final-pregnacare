<?php 
include_once("./Patient.php");
session_start();
$conn = new mysqli('localhost', 'root', 'password', 'Ouvatech');
$patient = new Patient($conn);

// Set patient's user ID
if(isset($_POST["dob"]) && isset($_POST["location"]) && isset($_POST["previous-pregnancies"]) && isset($_POST["pregnancy-stage"]) ){
    if(!$patient->checkID($_SESSION['user_id'])){
        $patient->setUserId();
    }
    $patient->setDateOfBirth($_POST["dob"]);
    $patient->setLocation($_POST["location"]);
    $patient->setPreviousPregnancies($_POST["previous-pregnancies"]);
    $patient->setPregnancyStage($_POST["pregnancy-stage"]);
}

if(isset($_POST["diabetics"])){
    if($_POST["diabetics"] === "true"){
        $patient->setDiabetic(1);
    }
    
} else {
    $patient->setDiabetic(0);
}


if(isset($_POST["hypertension"])){
    $patient->setHypertension(1);
} else {
    $patient->setHypertension(0);
}

?>