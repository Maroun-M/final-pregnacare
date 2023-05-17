<?php
include("../patient/Patient.php");
$conn = new mysqli('localhost', 'root', 'password', 'Ouvatech');
session_start();
$patient = new patient($conn);
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['patient'])) {
        $patient->getRecentUserData($_GET['patient']);
    } elseif (isset($_GET['ID']) && isset($_GET['range'])) {
        if($_GET['type'] === "Blood Glucose"){
            $patient->getBloodGlucoseData($_GET['ID'], $_GET['range']);
        } elseif($_GET['type'] === "Blood Oxygen"){
            $patient->getBloodOxygenData($_GET['ID'], $_GET['range']);
        }elseif($_GET['type'] === "Heart Rate"){
            $patient->getHRBPData($_GET['ID'], $_GET['range']);
        }elseif($_GET['type'] === "Blood Pressure"){
            $patient->getBPData($_GET['ID'], $_GET['range']);
        }elseif($_GET['type'] === "Fetus Data"){
            $patient->getFetusData($_GET['ID'], $_GET['range']);
        }elseif($_GET['type'] === "Temperature"){
            $patient->getFetusData($_GET['ID'], $_GET['range']);
        }elseif($_GET['type'] === "Lab Tests"){
            $patient->getUserFilesData($_GET['ID'], $_GET['range']);
        }
    }
}

?>