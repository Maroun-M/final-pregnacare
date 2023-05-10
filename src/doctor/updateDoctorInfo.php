<?php
include_once("./Doctor.php");
session_start();
$doctor = new doctor();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the input fields from the form
    $user_id = $_SESSION["user_id"];
    $location = $_POST["location"];
    $education = $_POST["education"];
    $clinic_number = $_POST["clinic_number"];
    $clinic_name = $_POST["clinic_name"];
    $date_of_birth = $_POST["dob"];
    // Call the insertOrUpdateData method to insert or update the data in the database
    if ($doctor->insertDoctorData($user_id, $location, $education, $clinic_number, $clinic_name, $date_of_birth)) {
      header("location: ../../doctorInfo.php?update=success");
    } else {
      // Insert or update failed
      header("location: ../../doctorInfo.php?update=failed");

    }
  }
?>