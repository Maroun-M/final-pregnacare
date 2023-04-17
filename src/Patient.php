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

}

?>