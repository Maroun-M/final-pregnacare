<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Ouvatech</title>
  <link rel="stylesheet" href="./style.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap"
    rel="stylesheet" />

  <script src="./doctorApp.js" defer></script>
</head>

<body>
  <?php
  session_start();
  include_once("./src/doctor/Doctor.php");
  $conn = new mysqli('localhost', 'root', 'password', 'Ouvatech');
  $doctor = new Doctor();
  if (!isset($_SESSION['user_id']) || !$doctor->isDoctor($_SESSION['user_id'])) { // Check if the user is logged in and is doctor
    echo "You don't have access to this page.";
    exit();
  }
  if (!$doctor->isDoctorConfirmed($_SESSION['user_id'])) {
    header("location:./confirm.php");
    exit();
  }



  if (!$doctor->has_doctor_record($_SESSION['user_id'])) {
    header("location:./doctorInfo.php");
    exit();
  }
  ?>
  <div class="dr-container tests-container">
    <div class="header">Test</div>
    <div class="header">Values</div>
    <div class="header">Date</div>
    <div class="header">Time</div>
  </div>
  <div class="dr-container tests-data-container data-container tests-container">
    <!-- Add more patient data items here -->


  </div>
  <div> <button class="graphs-btn">Detailed Records</button>
  </div>
</body>

</html>