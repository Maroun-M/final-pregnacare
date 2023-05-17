<?php
class Patient
{
  private $conn;
  private $userId;

  public function __construct($conn)
  {
    $this->conn = $conn;
    $this->userId = $_SESSION['user_id'];
  }

  public function setUserId()
  {
    $stmt = $this->conn->prepare("INSERT INTO patients(user_id) VALUES(?) ");
    $stmt->bind_param("i", $this->userId);
    $stmt->execute();
  }

  public function checkID($userID)
  {
    $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM patients WHERE user_id = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
  }

  public function getLocation()
  {
    $stmt = $this->conn->prepare("SELECT location FROM patients WHERE user_id = ?");
    $stmt->bind_param("i", $this->userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['location'];
  }

  // Setter for patient location
  public function setLocation($location)
  {
    $stmt = $this->conn->prepare("UPDATE patients SET location = ? WHERE user_id = ?");
    $stmt->bind_param("si", $location, $this->userId);
    $stmt->execute();
  }

  // Getter for date of birth
  public function getDateOfBirth()
  {
    $stmt = $this->conn->prepare("SELECT date_of_birth FROM patients WHERE user_id = ?");
    $stmt->bind_param("i", $this->userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['date_of_birth'];
  }

  // Setter for date of birth
  public function setDateOfBirth($dateOfBirth)
  {
    $stmt = $this->conn->prepare("UPDATE patients SET date_of_birth = ? WHERE user_id = ?");
    $stmt->bind_param("si", $dateOfBirth, $this->userId);
    $stmt->execute();
  }

  // Getter for age
  public function getAge()
  {
    $stmt = $this->conn->prepare("SELECT FLOOR(DATEDIFF(CURRENT_DATE, date_of_birth)/365) AS age FROM patients WHERE user_id = ?");
    $stmt->bind_param("i", $this->userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['age'];
  }

  // Getter for previous pregnancies
  public function getPreviousPregnancies()
  {
    $stmt = $this->conn->prepare("SELECT previous_pregnancies FROM patients WHERE user_id = ?");
    $stmt->bind_param("i", $this->userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['previous_pregnancies'];
  }

  // Setter for previous pregnancies
  public function setPreviousPregnancies($previousPregnancies)
  {
    if ($previousPregnancies === "true") {
      $previousPregnancies = 1;
    } else {
      $previousPregnancies = 0;
    }
    $stmt = $this->conn->prepare("UPDATE patients SET previous_pregnancies = ? WHERE user_id = ?");
    $stmt->bind_param("si", $previousPregnancies, $this->userId);
    $stmt->execute();
  }

  // Getter for pregnancy stage
  public function getPregnancyStage()
  {
    $stmt = $this->conn->prepare("SELECT pregnancy_stage FROM patients WHERE user_id = ?");
    $stmt->bind_param("i", $this->userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['pregnancy_stage'];
  }

  // Setter for pregnancy stage
  public function setPregnancyStage($pregnancyStage)
  {
    $stmt = $this->conn->prepare("UPDATE patients SET pregnancy_stage = ? WHERE user_id = ?");
    $stmt->bind_param("si", $pregnancyStage, $this->userId);
    $stmt->execute();
  }

  // Getter for diabetic
  public function getDiabetic()
  {
    $stmt = $this->conn->prepare("SELECT diabetic FROM patients WHERE user_id = ?");
    $stmt->bind_param("i", $this->userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['diabetic'];
  }

  // Setter for diabetic
  public function setDiabetic($diabetic)
  {
    $stmt = $this->conn->prepare("UPDATE patients SET diabetic = ? WHERE user_id = ?");
    $stmt->bind_param("si", $diabetic, $this->userId);
    $stmt->execute();
  }

  // Getter for hypertension
  public function getHypertension()
  {
    $stmt = $this->conn->prepare("SELECT hypertension FROM patients WHERE user_id = ?");
    $stmt->bind_param("i", $this->userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['hypertension'];
  }

  // Setter for hypertension
  public function setHypertension($hypertension)
  {
    $stmt = $this->conn->prepare("UPDATE patients SET hypertension = ? WHERE user_id = ?");
    $stmt->bind_param("si", $hypertension, $this->userId);
    $stmt->execute();
  }
  public function getAllInfo()
  {
    $data = array(
      'dob' => $this->getDateOfBirth(),
      'location' => $this->getLocation(),
      'prevPreg' => $this->getPreviousPregnancies(),
      'stage' => $this->getPregnancyStage(),
      'diabetic' => $this->getDiabetic(),
      'hypertension' => $this->getHypertension()
    );
    return $data;
  }

  public function insert_hr_bp($bpm, $systolic, $diastolic, $user_id)
  {
    // Validate that inputs are integers
    $bpm = (int) $bpm;
    $systolic = (int) $systolic;
    $diastolic = (int) $diastolic;

    // Sanitize inputs
    $bpm = filter_var($bpm, FILTER_SANITIZE_NUMBER_INT);
    $systolic = filter_var($systolic, FILTER_SANITIZE_NUMBER_INT);
    $diastolic = filter_var($diastolic, FILTER_SANITIZE_NUMBER_INT);
    $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);

    // Validate bpm is within reasonable range
    if ($bpm < 40 || $bpm > 200) {
      return "Error: Invalid BPM value.";
    }

    // Validate systolic and diastolic are within reasonable range
    if ($systolic < 70 || $systolic > 200 || $diastolic < 40 || $diastolic > 120) {
      return "Error: Invalid systolic or diastolic blood pressure value.";
    }

    // Prepare and bind statement
    $stmt = $this->conn->prepare("INSERT INTO hr_bp (user_id, bpm, systolic, diastolic) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
      printf("Query Prep Failed: %s\n", $this->conn->error);
      exit;
    }

    $stmt->bind_param("iiii", $user_id, $bpm, $systolic, $diastolic);


    // Execute statement and check for errors
    if ($stmt->execute() === TRUE) {
      // Close statement and connection

      $stmt->close();
      $this->conn->close();
      header("LOCATION: ../../heartRate.php");
      return "Success: New record created successfully.";
    } else {
      return "Error: " . $stmt->error;
    }
  }

  public function addTemperature($temperature, $userId)
  {
    // Validate temperature
    if (!is_numeric($temperature) || $temperature < 34 || $temperature > 43) {
      return false;
    }

    // Sanitize input
    $temperature = filter_var($temperature, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);

    // Insert into database


    $stmt = $this->conn->prepare("INSERT INTO temperature (user_id, temp) VALUES (?, ?)");
    $stmt->bind_param("sd", $userId, $temperature);

    // Execute statement and check for errors
    if ($stmt->execute() === TRUE) {
      // Close statement and connection
      $stmt->close();
      $this->conn->close();
      header("LOCATION: ../../temperature.php");
      return true;
    } else {
      return "Error: " . $stmt->error;
    }
  }

  public function insert_blood_oxygen($blood_oxygen, $user_id)
  {
    // Validate input
    if (!is_numeric($blood_oxygen) || $blood_oxygen < 0 || $blood_oxygen > 100) {
      return false; // Invalid input
    }

    // Sanitize input
    $blood_oxygen = filter_var($blood_oxygen, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);


    // Prepare and bind SQL statement
    $stmt = $this->conn->prepare("INSERT INTO blood_oxygen (user_id, percentage) VALUES (?, ?)");
    $stmt->bind_param("id", $user_id, $blood_oxygen);

    // Execute SQL statement and check for errors
    if (!$stmt->execute()) {
      $stmt->close();
      $this->conn->close();
      return false; // SQL error
    }

    $stmt->close();
    $this->conn->close();
    header("LOCATION: ../../bloodOxygen.php");

    return true; // Success
  }

  public function insertBloodGlucose($blood_glucose, $user_id)
  {

    // Sanitize blood glucose level
    $blood_glucose = filter_var($blood_glucose, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Validate blood glucose level
    if (!is_numeric($blood_glucose) || $blood_glucose < 0 || $blood_glucose > 100) {
      return false;
    }

    // Prepare and bind the insert statement
    $stmt = $this->conn->prepare("INSERT INTO blood_glucose(user_id, glucose_level) VALUES (?, ?)");
    $stmt->bind_param("id", $user_id, $blood_glucose);

    // Execute SQL statement and check for errors
    if (!$stmt->execute()) {
      $stmt->close();
      $this->conn->close();
      return false; // SQL error
    }

    $stmt->close();
    $this->conn->close();
    header("LOCATION: ../../bloodGlucose.php");
    return true; // Success
  }

  function insertOrUpdateFetusRecord($user_id, $gestational_age, $weight, $heart_rate)
  {
    // Validate inputs
    if (!is_numeric($gestational_age) || $gestational_age <= 0 || !ctype_digit($gestational_age)) {
      return false;
    }

    // Check that weight is a positive float or integer within a reasonable range
    if (!is_numeric($weight) || $weight <= 0 || $weight > 5000) {
      return false;
    }

    // Check that heart rate is a positive integer within a reasonable range
    if (!is_numeric($heart_rate) || $heart_rate <= 0 || $heart_rate > 200) {
      return false;
    }

    // Sanitize inputs
    $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
    $gestational_age = filter_var($gestational_age, FILTER_SANITIZE_NUMBER_INT);
    $weight = filter_var($weight, FILTER_SANITIZE_NUMBER_INT);
    $heart_rate = filter_var($heart_rate, FILTER_SANITIZE_NUMBER_INT);

    // Insert data into database

    $stmt = $this->conn->prepare("INSERT INTO fetus (user_id, gestational_age, weight, heart_rate) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iddd", $user_id, $gestational_age, $weight, $heart_rate);

    if (!$stmt->execute()) {
      $stmt->close();
      $this->conn->close();
      return false; // SQL error
    }

    $stmt->close();
    $this->conn->close();
    header("LOCATION: ../../fetus.php");
    return true; // Success

  }




  // authentications for the patient to be able to access the main menu of patients

  public function isUserConfirmed($user_id)
  {
    $query = "SELECT confirmed FROM users WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    if (!$stmt) {
      die("Error preparing statement: " . $this->conn->error);
    }
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
      die("Error executing statement: " . $stmt->error);
    }
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user['confirmed'] == 1) {
      return true;
    } else {
      return false;
    }
  }

  // checks the access level of the user if he is patient
  public function isPatient($user_id)
  {
    $query = "SELECT access_level FROM users WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user['access_level'] == 1) {
      return true;
    } else {
      return false;
    }
  }

  // checks if the patient has a record in the table patient
  public function has_patient_record($user_id)
  {
    echo $user_id;
    $stmt = $this->conn->prepare("SELECT * FROM patients WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
  }

  // returns the patients data for the doctor tab
  public function getPatientsByDoctorId($doctor_id)
  {

    // Prepare the SQL statement to join the tables and retrieve the patient data
    $stmt = $this->conn->prepare("
    SELECT u.id, p.location, CONCAT(u.first_name, ' ', u.last_name) AS name, u.phone_number, TIMESTAMPDIFF(YEAR, p.date_of_birth, CURDATE()) AS age FROM patients p JOIN patient_doctor pd ON p.patient_id = pd.patient_id JOIN users u ON p.user_id = u.id JOIN doctors d ON pd.doctor_id = d.doctor_id WHERE d.user_id = ?;
    
    ");
    // Bind the doctor ID parameter to the SQL statement
    $stmt->bind_param('i', $doctor_id);

    // Execute the SQL statement
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Fetch the patient data as an associative array
    $patients = [];
    while ($row = $result->fetch_assoc()) {
      $patients[] = $row;
    }

    // Loop through the patient data and calculate the age of each patient


    // Close the database connection
    $this->conn->close();
    echo json_encode($patients);
    // Return the patient data as a JSON array
    return true;
  }

  public function getRecentUserData($user_id)
  {
    // Set the user_id parameter for the query
    $user_id = $this->conn->real_escape_string($user_id);

    // Prepare and execute the query for each table
    $tables = array('blood_glucose', 'blood_oxygen', 'fetus', 'hr_bp', 'temperature', 'user_files');
    $data = array();

    foreach ($tables as $table) {
      $sql = "SELECT * FROM $table WHERE user_id = '$user_id' ORDER BY timestamp DESC LIMIT 1";
      $result = $this->conn->query($sql);

      if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $timestamp = $row['timestamp'];
        $row['date'] = date('Y-m-d', strtotime($timestamp));
        $row['time'] = date('H:i:s', strtotime($timestamp));
        unset($row['timestamp']);
        $data[$table] = $row;
      } else {
        $data[$table] = array();
      }
    }

    // Close the database connection
    $this->conn->close();

    // Echo the data as a JSON array
    echo json_encode($data);
  }

  public function getBloodGlucoseData($user_id, $time_range)
  {
    // Set the user_id and time_range parameters for the query
    $user_id = $this->conn->real_escape_string($user_id);
    $time_range = $this->conn->real_escape_string($time_range);
    
    // Calculate the start and end dates based on the time range
    $start_date = '';
    $end_date = date('Y-m-d');
    if ($time_range === 'weekly') {
      $start_date = date('Y-m-d', strtotime('-1 week'));
    } elseif ($time_range === 'monthly') {
      $start_date = date('Y-m-d', strtotime('-1 month'));
    } elseif ($time_range === 'yearly') {
      $start_date = date('Y-m-d', strtotime('-1 year'));
    }
    // Prepare and execute the query
    $sql = "SELECT record_id, user_id, glucose_level, DATE(timestamp) AS date, TIME(timestamp) AS time 
          FROM blood_glucose 
          WHERE user_id = $user_id AND DATE(timestamp) BETWEEN '$start_date' AND '$end_date'";
    $result = $this->conn->query($sql);

    // Check if the query was successful
    if ($result) {
      $data = array();

      // Fetch the result rows and process the data
      while ($row = $result->fetch_assoc()) {
        $data[] = array(
          'record_id' => $row['record_id'],
          'user_id' => $row['user_id'],
          'value' => $row['glucose_level'],
          'date' => $row['date'],
          'time' => $row['time']
        );
      }

      // Echo the data as a JSON array
      echo json_encode($data);
    } else {
      // Handle query error
      echo 'Error: ' . $this->conn->error;
    }
  }

  public function getBloodOxygenData($user_id, $time_range)
  {
    // Set the user_id and time_range parameters for the query
    $user_id = $this->conn->real_escape_string($user_id);

    // Calculate the start and end dates based on the time range
    $start_date = '';
    $end_date = date('Y-m-d');

    if ($time_range === 'weekly') {
      $start_date = date('Y-m-d', strtotime('-1 week'));
    } elseif ($time_range === 'monthly') {
      $start_date = date('Y-m-d', strtotime('-1 month'));
    } elseif ($time_range === 'yearly') {
      $start_date = date('Y-m-d', strtotime('-1 year'));
    }
    // Prepare and execute the query
    $sql = "SELECT record_id, user_id, percentage, DATE(timestamp) AS date, TIME(timestamp) AS time 
          FROM blood_oxygen 
          WHERE user_id = '$user_id' AND DATE(timestamp) BETWEEN '$start_date' AND '$end_date'";
    $result = $this->conn->query($sql);

    // Check if the query was successful
    if ($result) {
      $data = array();

      // Fetch the result rows and process the data
      while ($row = $result->fetch_assoc()) {
        $data[] = array(
          'record_id' => $row['record_id'],
          'user_id' => $row['user_id'],
          'value' => $row['percentage'],
          'date' => $row['date'],
          'time' => $row['time']
        );
      }

      // Echo the data as a JSON array
      echo json_encode($data);
    } else {
      // Handle query error
      echo 'Error: ' . $this->conn->error;
    }
  }

  public function getFetusData($user_id, $time_range)
  {
    // Set the user_id and time_range parameters for the query
    $user_id = $this->conn->real_escape_string($user_id);
    // Calculate the start and end dates based on the time range
    $start_date = '';
    $end_date = date('Y-m-d');

    if ($time_range === 'weekly') {
      $start_date = date('Y-m-d', strtotime('-1 week'));
    } elseif ($time_range === 'monthly') {
      $start_date = date('Y-m-d', strtotime('-1 month'));
    } elseif ($time_range === 'yearly') {
      $start_date = date('Y-m-d', strtotime('-1 year'));
    }

    // Prepare and execute the query
    $sql = "SELECT id, user_id, gestational_age, weight, heart_rate, DATE(timestamp) AS date, TIME(timestamp) AS time 
        FROM fetus 
        WHERE user_id = '$user_id' AND DATE(timestamp) BETWEEN '$start_date' AND '$end_date'";
    $result = $this->conn->query($sql);

    // Check if the query was successful
    if ($result) {
      $data = array();

      // Fetch the result rows and process the data
      while ($row = $result->fetch_assoc()) {
        $data[] = array(
          'id' => $row['id'],
          'user_id' => $row['user_id'],
          'gestational_age' => $row['gestational_age'],
          'weight' => $row['weight'],
          'heart_rate' => $row['heart_rate'],
          'date' => $row['date'],
          'time' => $row['time']
        );
      }

      // Echo the data as a JSON array
      echo json_encode($data);
    } else {
      // Handle query error
      echo 'Error: ' . $this->conn->error;
    }
  }


  public function getHRBPData($user_id, $time_range)
  {
    // Set the user_id and time_range parameters for the query
    $user_id = $this->conn->real_escape_string($user_id);

    // Calculate the start and end dates based on the time range
    $start_date = '';
    $end_date = date('Y-m-d');

    if ($time_range === 'weekly') {
      $start_date = date('Y-m-d', strtotime('-1 week'));
    } elseif ($time_range === 'monthly') {
      $start_date = date('Y-m-d', strtotime('-1 month'));
    } elseif ($time_range === 'yearly') {
      $start_date = date('Y-m-d', strtotime('-1 year'));
    }

    // Prepare and execute the query
    $sql = "SELECT HR_BP_record_id, user_id, DATE(timestamp) AS date, TIME(timestamp) AS time, bpm, systolic, diastolic 
            FROM hr_bp 
            WHERE user_id = '$user_id' AND DATE(timestamp) BETWEEN '$start_date' AND '$end_date'";
    $result = $this->conn->query($sql);

    // Check if the query was successful
    if ($result) {
      $data = array();

      // Fetch the result rows and process the data
      while ($row = $result->fetch_assoc()) {
        $data[] = array(
          'HR_record_id' => $row['HR_BP_record_id'],
          'user_id' => $row['user_id'],
          'date' => $row['date'],
          'time' => $row['time'],
          'value' => $row['bpm'],
      
        );
      }

      // Echo the data as a JSON array
      echo json_encode($data);
    } else {
      // Handle query error
      echo 'Error: ' . $this->conn->error;
    }
  }

  public function getBPData($user_id, $time_range)
  {
    // Set the user_id and time_range parameters for the query
    $user_id = $this->conn->real_escape_string($user_id);

    // Calculate the start and end dates based on the time range
    $start_date = '';
    $end_date = date('Y-m-d');

    if ($time_range === 'weekly') {
      $start_date = date('Y-m-d', strtotime('-1 week'));
    } elseif ($time_range === 'monthly') {
      $start_date = date('Y-m-d', strtotime('-1 month'));
    } elseif ($time_range === 'yearly') {
      $start_date = date('Y-m-d', strtotime('-1 year'));
    }

    // Prepare and execute the query
    $sql = "SELECT HR_BP_record_id, user_id, DATE(timestamp) AS date, TIME(timestamp) AS time, systolic, diastolic 
            FROM hr_bp 
            WHERE user_id = '$user_id' AND DATE(timestamp) BETWEEN '$start_date' AND '$end_date'";
    $result = $this->conn->query($sql);

    // Check if the query was successful
    if ($result) {
      $data = array();

      // Fetch the result rows and process the data
      while ($row = $result->fetch_assoc()) {
        $data[] = array(
          'BP_record_id' => $row['HR_BP_record_id'],
          'user_id' => $row['user_id'],
          'date' => $row['date'],
          'time' => $row['time'],
          'systolic' => $row['systolic'],
          'diastolic' => $row['diastolic']
        );
      }

      // Echo the data as a JSON array
      echo json_encode($data);
    } else {
      // Handle query error
      echo 'Error: ' . $this->conn->error;
    }
  }

  public function getTemperatureData($user_id, $time_range)
  {
    // Set the user_id and time_range parameters for the query
    $user_id = $this->conn->real_escape_string($user_id);

    // Calculate the start and end dates based on the time range
    $start_date = '';
    $end_date = date('Y-m-d');

    if ($time_range === 'weekly') {
      $start_date = date('Y-m-d', strtotime('-1 week'));
    } elseif ($time_range === 'monthly') {
      $start_date = date('Y-m-d', strtotime('-1 month'));
    } elseif ($time_range === 'yearly') {
      $start_date = date('Y-m-d', strtotime('-1 year'));
    }

    // Prepare and execute the query
    $sql = "SELECT record_id, user_id, temp, DATE(timestamp) AS date, TIME(timestamp) AS time 
          FROM temperature 
          WHERE user_id = '$user_id' AND DATE(timestamp) BETWEEN '$start_date' AND '$end_date'";
    $result = $this->conn->query($sql);

    // Check if the query was successful
    if ($result) {
      $data = array();

      // Fetch the result rows and process the data
      while ($row = $result->fetch_assoc()) {
        $data[] = array(
          'record_id' => $row['record_id'],
          'user_id' => $row['user_id'],
          'value' => $row['temp'],
          'date' => $row['date'],
          'time' => $row['time']
        );
      }

      // Echo the data as a JSON array
      echo json_encode($data);
    } else {
      // Handle query error
      echo 'Error: ' . $this->conn->error;
    }
  }


  public function getUserFilesData($user_id, $time_range)
  {
    // Set the user_id and time_range parameters for the query
    $user_id = $this->conn->real_escape_string($user_id);

    // Calculate the start and end dates based on the time range
    $start_date = '';
    $end_date = date('Y-m-d');

    if ($time_range === 'weekly') {
      $start_date = date('Y-m-d', strtotime('-1 week'));
    } elseif ($time_range === 'monthly') {
      $start_date = date('Y-m-d', strtotime('-1 month'));
    } elseif ($time_range === 'yearly') {
      $start_date = date('Y-m-d', strtotime('-1 year'));
    }

    // Prepare and execute the query
    $sql = "SELECT id, user_id, DATE(timestamp) AS date, TIME(timestamp) AS time, file_path 
          FROM user_files 
          WHERE user_id = '$user_id' AND DATE(timestamp) BETWEEN '$start_date' AND '$end_date'";
    $result = $this->conn->query($sql);

    // Check if the query was successful
    if ($result) {
      $data = array();

      // Fetch the result rows and process the data
      while ($row = $result->fetch_assoc()) {
        $data[] = array(
          'id' => $row['id'],
          'user_id' => $row['user_id'],
          'date' => $row['date'],
          'time' => $row['time'],
          'file_path' => $row['file_path']
        );
      }

      // Echo the data as a JSON array
      echo json_encode($data);
    } else {
      // Handle query error
      echo 'Error: ' . $this->conn->error;
    }
  }



}



?>