<?php
class Doctor
{
  private $conn;

  public function __construct()
  {
    $this->conn = new mysqli('localhost', 'root', 'password', 'Ouvatech');
  }

  public function isDoctorConfirmed($user_id)
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

  public function isDoctor($user_id)
  {
    $query = "SELECT access_level FROM users WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user['access_level'] == 2) {
      return true;
    } else {
      return false;
    }
  }
  public function has_doctor_record($user_id)
  {
    // Assuming you have already connected to your database and stored the connection in a variable called $conn
    $stmt = $this->conn->prepare("SELECT * FROM doctors WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
  }

  public function insertDoctorData($user_id, $location, $education, $clinic_number, $clinic_name, $date_of_birth)
  {
    // Validate input fields
    if (empty($user_id) || empty($location) || empty($education) || empty($clinic_number) || empty($clinic_name) || empty($date_of_birth)) {
      // One or more fields are empty, handle the error as appropriate (e.g. display an error message to the user)
      return false;
    }
    if (empty($user_id) || !is_numeric($user_id) || $user_id <= 0) {
      // User ID is not a positive integer, handle the error as appropriate (e.g. display an error message to the user)
      return false;
    }
    if (empty($location) || !is_string($location)) {
      // Location is not a non-empty string, handle the error as appropriate (e.g. display an error message to the user)
      return false;
    }
    if (empty($education) || !is_string($education)) {
      // Education is not a non-empty string, handle the error as appropriate (e.g. display an error message to the user)
      return false;
    }
    // Validate phone number
    if (empty($clinic_number)) {
      $errors['phoneNumber'] = "Phone number is required.";
    } elseif (!preg_match("/^\+(?:[0-9] ?){6,14}[0-9]$/", $clinic_number)) {
      $errors['phoneNumber'] = "Invalid phone number.";
    }
    if (empty($clinic_name) || !is_string($clinic_name)) {
      // Clinic name is not a non-empty string, handle the error as appropriate (e.g. display an error message to the user)
      return false;
    }
    if (empty($date_of_birth) || !DateTime::createFromFormat('Y-m-d', $date_of_birth)) {
      // Date of birth is not a valid date in the format YYYY-MM-DD, handle the error as appropriate (e.g. display an error message to the user)
      return false;
    }

    // Sanitize input fields
    $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
    $location = filter_var($location, FILTER_SANITIZE_STRING);
    $education = filter_var($education, FILTER_SANITIZE_STRING);
    $clinic_number = filter_var($clinic_number, FILTER_SANITIZE_STRING);
    $clinic_name = filter_var($clinic_name, FILTER_SANITIZE_STRING);
    $date_of_birth = filter_var($date_of_birth, FILTER_SANITIZE_STRING);

    // Check if a record with the given user_id already exists
    if ($this->has_doctor_record($user_id)) {
      // A record already exists, update it with the new data
      $sql = "UPDATE doctors SET location = ?, education = ?, clinic_number = ?, clinic_name = ?, date_of_birth = ? WHERE user_id = ?";
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param("sssssi", $location, $education, $clinic_number, $clinic_name, $date_of_birth, $user_id);
    } else {
      // No record exists, insert a new one with the provided data
      $sql = "INSERT INTO doctors (user_id, location, education, clinic_number, clinic_name, date_of_birth) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param("isssss", $user_id, $location, $education, $clinic_number, $clinic_name, $date_of_birth);
    }

    // Execute the prepared statement
    if ($stmt->execute()) {
      // Insert/update successful
      return true;
    } else {
      // Insert/update failed, handle the error as appropriate (e.g. log the error or display an error message to the user)
      return false;
    }
  }

  public function getTotalDoctors()
  {

    // Number of results per page
    $resultsPerPage = 10;

    // Query to get the total number of doctors
    $countQuery = "SELECT COUNT(*) AS total FROM doctors";
    $countResult = $this->conn->query($countQuery);
    $totalDoctors = $countResult->fetch_assoc()['total'];

    // Calculate the total number of pages
    $totalPages = ceil($totalDoctors / $resultsPerPage);

    // Output the total number of pages as JSON
    header("Content-Type: application/json");
    echo json_encode(['totalPages' => $totalPages]);

  }
  public function getDoctors($page)
  { // Validate and sanitize the page number
    $page = filter_var($page, FILTER_VALIDATE_INT);
    $page = ($page !== false && $page > 0) ? $page : 1;
    // Number of results per page
    $resultsPerPage = 10;

    // Calculate the offset for the current page
    $offset = ($page - 1) * $resultsPerPage;

    // Prepare the query to fetch doctors
    $query = "SELECT doctors.*, users.phone_number, CONCAT(users.first_name, ' ', users.last_name) AS name
    FROM doctors 
    JOIN users ON doctors.user_id = users.id LIMIT ?, ?;";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("ii", $offset, $resultsPerPage);
    $stmt->execute();

    // Get the result set
    $result = $stmt->get_result();

    // Fetch the doctors into an array
    $doctors = [];
    while ($row = $result->fetch_assoc()) {
      $doctors[] = $row;
    }

    // Close the statement
    $stmt->close();

    // Output the doctors as JSON
    header("Content-Type: application/json");
    echo json_encode($doctors);
  }


  public function fetchDoctorsDataAsJson($userID) {
    $query = "SELECT * FROM doctors WHERE user_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();

    while ($row = $result->fetch_assoc()) {
      $data = $row;
    }

    // Set the appropriate header for JSON response
    header('Content-Type: application/json');

    // Echo the data as JSON
    echo json_encode($data);
  }
}

?>