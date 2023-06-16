<?php
class Login
{
    private $conn; // holds database connection object

    // constructor takes a database connection object as parameter
    public function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', 'password', 'Ouvatech');
        ;

    }

    
    public function login($email, $password, $token)
    {
        if (empty($email) || empty($password) || empty($token) || !hash_equals($_SESSION['token'], $token)) {
            return false;
        }
    
        // sanitize input to prevent SQL injection attacks
        $email = mysqli_real_escape_string($this->conn, $email);
        $password = mysqli_real_escape_string($this->conn, $password);
    
        // Prepare query to select user by email
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
    
        // Get result set
        $result = $stmt->get_result();
    
        // Check if user exists
        $row = $result->fetch_assoc();
    
        if ($result->num_rows == 1 && password_verify($password, $row['account_password'])) {
            
                //  Set user information
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_email'] = $row['email'];            
                return true;
            
        } else {
            // Invalid email or password
            echo 'Invalid email or password';
            return false;
        }
    
    }

    public function confirmUser($email, $confirmationCode)
    {
        $email = $this->conn->real_escape_string($email);
        $confirmationCode = $this->conn->real_escape_string($confirmationCode);
        
        // Check if the confirmation code belongs to the email
        $query = "SELECT * FROM users WHERE email = ? AND confirmation_code = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $email, $confirmationCode);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if (!$result || $result->num_rows == 0) {
            return false;
        }
        
        // Update the confirmation status
        $query = "UPDATE users SET confirmed = 1 WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        header("location: ../../index.php?account=confirmed");
        return true;
    }
    private $accessLevel;

     public function getUserAccessLevel($userId) {
      
      
        
      // Prepare and execute the SQL query
      $stmt = $this->conn->prepare("SELECT access_level FROM users WHERE id = ?");
      $stmt->bind_param("i", $userId);
      $stmt->execute();
      $stmt->bind_result($this->accessLevel);
      $stmt->fetch();
    
    
      // Return the access level as an integer
      return (int) $this->accessLevel;
    }

   
      
  
    
    
    
    
}
?>