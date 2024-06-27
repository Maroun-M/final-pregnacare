<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/png" href="./images/pregnaCareLogo.png">
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PregnaCare</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@^3"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1"></script>




<!-- Your custom JavaScript -->
<script type="module" src="chat.js" defer></script>
  <?php 
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  
    session_start();
    include_once("./src/patient/Patient.php");
    $conn = new mysqli('localhost', 'id22338592_pregnacare', 'Pregna@@00', 'id22338592_pregnacare');
    $patient = new Patient($conn);
    if(!isset($_SESSION['user_id']) || !$patient->isPatient($_SESSION['user_id'])) { // Check if the user is logged in and is patient
      echo "You don't have access to this page.";
      header("LOCATION: ./index.php?access=unauthorized");
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

    $stmt = $conn->prepare("
    SELECT u.id AS doctor_user_id
    FROM patients p
    JOIN patient_doctor pd ON p.patient_id = pd.patient_id
    JOIN doctors d ON pd.doctor_id = d.doctor_id
    JOIN users u ON d.user_id = u.id
    WHERE p.user_id = ?
");
// Bind the parameter
$stmt->bind_param("i", $_SESSION['user_id']); // Assuming $_SESSION['user_id'] contains the user_id of the patient
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch the doctor_user_id
$row = $result->fetch_assoc();
$receiver_id = $row['doctor_user_id'];

// Close the statement
$stmt->close();

// Now $doctor_user_id contains the user ID of the doctor associated with the patient's user_id


  ?> 
</head>
<body>
  <p class="user-id" hidden ><?php echo $_SESSION['user_id'] ?></p>
  <p class="receiver-id" hidden ><?php echo $receiver_id ?></p>

  <div class="dashboard-wrapper">
    <!--  sidebar section -->
    <div class="sidebar gradient-background">
      <div class="sidebar-close-btn">
        <i class="bi bi-x-circle"></i>
      </div>
      <div class="sidebar-logo-container">
        <img src="./images/pregnaCareLogo.png" alt="" onclick="window.location.href = './index.php'">
      </div>
      <hr class="sidebar-divider">
      <div class="sidebar-nav-container" onclick="window.location.href = './patientMainMenu.php'">
        <div class="sidebar-nav-logo">
          <i class="bi bi-house-fill"></i>
        </div>
        <div class="sidebar-nav-name">
          <p>Home</p>
        </div>
      </div>
      <hr class="sidebar-divider">
      <div class="sidebar-header">
        <p>TESTS</p>
      </div>
      <div class="sidebar-nav-container" onclick="window.location.href = './heartRate.php'">
        <div class="sidebar-nav-logo">
          <i class="bi bi-heart-pulse-fill"></i>
        </div>
        <div class="sidebar-nav-name">
          <p>Heart Rate</p>
        </div>
      </div>
      <div class="sidebar-nav-container" onclick="window.location.href = './bloodPressure.php'">
        <div class="sidebar-nav-logo">
          <img src="./icons/blood_pressure_monitor.svg" alt="">
        </div>
        <div class="sidebar-nav-name">
          <p>Blood Pressure</p>
        </div>
      </div>
      <div class="sidebar-nav-container" onclick="window.location.href = './temperature.php'">
        <div class="sidebar-nav-logo">
          <i class="bi bi-thermometer-half"></i>
        </div>
        <div class="sidebar-nav-name">
          <p>Temperature</p>
        </div>
      </div>
      <div class="sidebar-nav-container" onclick="window.location.href = './bloodGlucose.php'">
        <div class="sidebar-nav-logo">
          <img src="./icons/diabetes.svg" alt="">
        </div>
        <div class="sidebar-nav-name">
          <p>Blood Glucose</p>
        </div>
      </div>
      <div class="sidebar-nav-container" onclick="window.location.href = './bloodOxygen.php'">
        <div class="sidebar-nav-logo">
          <img src="./icons/o2-oxygen-icon.svg" alt="">
        </div>
        <div class="sidebar-nav-name">
          <p>Blood Oxygen</p>
        </div>
      </div>
      <div class="sidebar-nav-container" onclick="window.location.href = './fetus.php'">
        <div class="sidebar-nav-logo">
          <img src="./icons/embryo-pregnancy-icon.svg" alt="">
        </div>
        <div class="sidebar-nav-name">
          <p>Fetus</p>
        </div>
      </div>
      <hr class="sidebar-divider">
      <div class="sidebar-header">
        <p>LAB TESTS</p>
      </div>
      <div class="sidebar-nav-container" onclick="window.location.href = './labTests.php'">
        <div class="sidebar-nav-logo">
          <img src="./icons/labtest.svg" alt="">
        </div>
        <div class="sidebar-nav-name">
          <p>Upload Tests</p>
        </div>
      </div>
      <hr class="sidebar-divider">
      <div class="sidebar-header">
        <p>AI</p>
      </div>
      <div class="sidebar-nav-container active" onclick="window.location.href = './AIChat.php'">
        <div class="sidebar-nav-logo">
          <img src="./icons/artificial-intelligence-ai-icon.svg" alt="">
        </div>
        <div class="sidebar-nav-name">
          <p>AI Assistant</p>
        </div>
      </div>

      <div class="sidebar-header">
        <p>Chatting</p>
      </div>
      <div class="sidebar-nav-container active" onclick="window.location.href = './message.php'">
        <div class="sidebar-nav-logo">
          <img src="./icons/message-svgrepo-com.svg" alt="">
        </div>
        <div class="sidebar-nav-name">
          <p>Chat</p>
        </div>
      </div>
      <hr class="sidebar-divider">

      

      <div class="sidebar-header">
        <p>PROFILE</p>
      </div>
      <div class="sidebar-nav-container" onclick="window.location.href = './userInfo.php'">
        <div class="sidebar-nav-logo">
          <img src="./icons/details.svg" alt="">
        </div>
        <div class="sidebar-nav-name">
          <p>Update Profile</p>
        </div>
      </div>
      <div class="sidebar-nav-container" onclick="window.location.href = './chooseDoctor.php'">
        <div class="sidebar-nav-logo">
          <i class="bi bi-hand-index"></i>
        </div>
        <div class="sidebar-nav-name">
          <p>Choose Doctor</p>
        </div>
      </div>
      <div class="sidebar-nav-container logout-btn">
        <div class="sidebar-nav-logo">
          <img src="./icons/logout.svg" alt="">
        </div>
        <div class="sidebar-nav-name">
          <p>Logout</p>
        </div>
      </div>
    </div>
    </div>
    <div class="content-wrap" style="height:100vh;">
      <div class="hamburger-container">
        <i class="bi bi-list"></i>
      </div>
      <!-- Page content start -->
      <div class="messaging-container">
        <div class="messaging-header">
          <h2>Chat</h2>
        </div>
        <div class="messaging-window" id="messaging-window">
          <!-- Messages will be appended here -->
        </div>
        <div class="messaging-input-container">
          <input type="text" id="messaging-input" placeholder="Type a message...">
          <button id="send-button">Send</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous" defer></script>
</body>
</html>


