<?php
include_once("./Doctor.php");
session_start();
$doctor = new doctor();
if (!isset($_SESSION['user_id'])) {
  // Handle the case when the user is not logged in
  echo "User not logged in";
  exit();
}


    $doctor->fetchDoctorsDataAsJson($_SESSION['user_id']);

?>