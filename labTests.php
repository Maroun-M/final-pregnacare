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
    if(!isset($_SESSION['user_id']) || !$patient->isPatient($_SESSION['user_id'])) { // Check if the user is logged in and is patient
      echo "You don't have access to this page.";
      exit();
   }
   if(!$patient->isUserConfirmed($_SESSION['user_id'])){
    header("location:./confirm.php");
    exit();
   }
  ?>
    <div class="user-info-wrap">

        <div class="login-form-container user-info-container heart-rate-inputs-container">
            <form action="./src/patient/upload.php" method="POST" enctype="multipart/form-data" class="heart-rate-form">
                <div class="info-update-logo-container">
                    <img src="./icons/labtest.svg" alt="">
                </div>
                <div class="form-inputs-container">
                    <div class="inputs-header-title">
                        <p>Please upload your lab tests:</p>
                    </div>
                    <div class="file-container">
                        <input type="file" id="lab-tests" name="lab-tests" required>
                    </div>       
                </div>
                <div class="login-btn-container update-btn-container">
                    <button class="login-btn update-btn add-btn">ADD</button>
                </div>
            </form>

        </div>
    </div>

</body>

</html>