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
      rel="stylesheet"
    />

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

   if (!$patient->has_patient_record($_SESSION['user_id'])){
    header("location:./userInfo.php");
    exit();
   }
  ?> 
  
    <div class="patient-menu-wrap">
      <div class="patient-menu-container">
        <div class="options-container">
          <div class="options-logo-container">
            <img src="./icons/heartRate.svg" alt="" onclick="window.location.href = './heartRate.php'"/>
          </div>
          <div class="options-title-container">
            <p onclick="window.location.href = './heartRate.php'">Heart Rate &<br>Blood Pressure</p>
          </div>
        </div>
        <div class="options-container">
          <div class="options-logo-container">
            <img src="./icons/temp.svg" alt="" onclick="window.location.href = './temperature.php'"/>
          </div>
          <div class="options-title-container">
            <p onclick="window.location.href = './temperature.php'">Temperature</p>
          </div>
        </div>
        <div class="options-container">
          <div class="options-logo-container">
            <img src="./icons/glucose.svg" alt="" onclick="window.location.href = './bloodGlucose.php'"/>
          </div>
          <div class="options-title-container">
            <p onclick="window.location.href = './bloodGlucose.php'">Blood Glucose</p>
          </div>
        </div>
        <div class="options-container">
          <div class="options-logo-container">
            <img src="./icons/labtest.svg" alt="" onclick="window.location.href = './labTests.php'"/>
          </div>
          <div class="options-title-container">
            <p onclick="window.location.href = './labTests.php'">Lab Test</p>
          </div>
        </div>
        <div class="options-container">
          <div class="options-logo-container">
            <img src="./icons/spo2.svg" alt="" onclick="window.location.href = './bloodOxygen.php'"/>
          </div>
          <div class="options-title-container">
            <p onclick="window.location.href = './bloodOxygen.php'">SpO2</p>
          </div>
        </div>
        <div class="options-container">
          <div class="options-logo-container">
            <img src="./icons/fetus.svg" alt="" onclick="window.location.href = './fetus.php'"/>
          </div>
          <div class="options-title-container">
            <p onclick="window.location.href = './fetus.php'">Fetus</p>
          </div>
        </div>
        <div class="options-container">
            <div class="options-logo-container">
              <img src="./icons/details.svg" alt="" onclick="window.location.href = './userInfo.php'">
            </div>
            <div class="options-title-container">
               <p onclick="window.location.href = './userInfo.php'">Details</p> 
            </div>
        </div>
        <div class="options-container">
            <div class="options-logo-container">
                <img src="./icons/logout.svg" alt="" class="logout-btn" >
            </div>
            <div class="options-title-container">
                <p class="logout-btn" >Log Out</p>
            </div>
        </div>
        <div class="options-container">
            <div class="options-logo-container">
              <img src="./icons/details.svg" alt="" onclick="window.location.href = './chooseDoctor.php'">
            </div>
            <div class="options-title-container">
               <p onclick="window.location.href = './chooseDoctor.php'">Choose Doctor</p> 
            </div>
        </div>
      </div>
    </div>
  </body>
</html>
