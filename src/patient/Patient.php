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
  public function has_patient_record($user_id) {
    echo $user_id;
    $stmt = $this->conn->prepare("SELECT * FROM patients WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows > 0;
  }

}

?>