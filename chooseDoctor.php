<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ouvatech</title>
    <link rel="stylesheet" href="style.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap"
        rel="stylesheet" />

    <script src="./patientApp.js" defer></script>
</head>

<body>
    <?php
    session_start();
    include_once("./src/patient/Patient.php");
    $conn = new mysqli('localhost', 'root', 'password', 'Ouvatech');
    $patient = new Patient($conn);
    if (!isset($_SESSION['user_id']) || !$patient->isPatient($_SESSION['user_id'])) { // Check if the user is logged in and is patient
        echo "You don't have access to this page.";
        exit();
    }
    if (!$patient->isUserConfirmed($_SESSION['user_id'])) {
        header("location:./confirm.php");
        exit();
    }

    if (!$patient->has_patient_record($_SESSION['user_id'])) {
        header("location:./userInfo.php");
        exit();
    }
    ?>
    <div class="grid-container">
        <div class="grid-item grid-header">Name</div>
        <div class="grid-item grid-header">Phone Number</div>
        <div class="grid-item grid-header">Education</div>

        <div class="grid-item grid-header">Clinic Name</div>
        <div class="grid-item grid-header">Clinic Number</div>
        <div class="grid-item grid-header">Location</div>

        <div class="grid-item grid-header">Pick Doctor</div>


    </div>
    <div class="grid-container doctor-list-data">
    
    </div>
    <div class="page-btns-container">

    </div>
</body>

</html>