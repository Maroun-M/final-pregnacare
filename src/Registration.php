<?php
include("../PHPMailer-master/src/PHPMailer.php");
include("../PHPMailer-master/src/SMTP.php");
include("../PHPMailer-master/src/Exception.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Registration
{  
    
    private $firstName;
    private $lastName;
    private $phoneNumber;
    private $email;
    private $password;
    private $confirmPassword;
    private $conn ;
    
    public function __construct($firstName, $lastName, $phoneNumber, $email, $password, $confirmPassword)
    { 
        $this->firstName = trim($firstName);
        $this->lastName = trim($lastName);
        $this->phoneNumber = trim($phoneNumber);
        $this->email = trim($email);
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
        $this->conn = new mysqli('localhost', 'root', 'password', 'Ouvatech');;
    }

    public function validate()
    {
        $errors = array();

        // Validate first name
        if (empty($this->firstName)) {
            $errors['firstName'] = "First name is required.";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $this->firstName)) {
            $errors['firstName'] = "Only letters allowed.";
        }
        
        // Validate last name
        if (empty($this->lastName)) {
            $errors['lastName'] = "Last name is required.";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $this->lastName)) {
            $errors['lastName'] = "Only letters allowed.";
        }
        
        // Validate phone number
        if (empty($this->phoneNumber)) {
            $errors['phoneNumber'] = "Phone number is required.";
        } elseif (!preg_match("/^\+(?:[0-9] ?){6,14}[0-9]$/", $this->phoneNumber)) {
            $errors['phoneNumber'] = "Invalid phone number.";
        }
        
        // Validate email
        if (empty($this->email)) {
            $errors['email'] = "Email is required.";
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }
        
        // Validate password
        if (empty($this->password)) {
            $errors['password'] = "Password is required.";
        } elseif (strlen($this->password) < 8 || !preg_match('/[A-Z]/', $this->password)) {
            $errors['password'] = "Password must be at least 8 characters long and contain at least one capital letter.";
        }
        
        // Validate confirm password
        if (empty($this->confirmPassword)) {
            $errors['confirmPassword'] = "Please confirm your password.";
        } elseif ($this->confirmPassword !== $this->password) {
            $errors['confirmPassword'] = "Passwords do not match.";
        }
        var_dump($errors);
        return $errors;
    }
    
    private function hashPassword($password)
    {
        $options = [
            'cost' => 12,
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }
    
    private function generateConfirmationCode()
    {
        $length = 6;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }
    
    public function register()
    {
        // Validate form data
        $errors = $this->validate();
        if (!empty($errors)) {
            return $errors;
    }
    
    // Check for duplicate email
    $email = $this->conn->real_escape_string($this->email);
    $query = "SELECT id FROM users WHERE email='$email'";
    $result = $this->conn->query($query);
    if ($result->num_rows > 0) {
        $errors['email'] = "Email is already registered.";
        echo $errors['email'];
        return $errors;
    }
    
    // Hash password
    $hashedPassword = $this->hashPassword($this->password);
    
    // Generate confirmation code
    $confirmationCode = $this->generateConfirmationCode();
    
    // Insert user data into database
    $firstName = $this->conn->real_escape_string($this->firstName);
    $lastName = $this->conn->real_escape_string($this->lastName);
    $phoneNumber = $this->conn->real_escape_string($this->phoneNumber);
    $email = $this->conn->real_escape_string($this->email);
    $query = "INSERT INTO users (first_name, last_name, phone_number, email, account_password, confirmation_code, access_level) 
              VALUES ('$firstName', '$lastName', '$phoneNumber', '$email', '$hashedPassword', '$confirmationCode', '1')";
    $result = $this->conn->query($query);
    $this->conn->close();
    // Send confirmation email  
    
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'maroun233245@gmail.com';
    $mail->Password = 'kheqpudxbrnxadlc';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $to = $this->email;
    $mail->setFrom('maroun233245@gmail.com', 'Ouvatech');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = "Confirm your registration";
    $mail->Body = "Thank you for registering! Your confirmation code is: <p color='blue'><bold>$confirmationCode</bold></p> Or confirm by clicking on the link below:";
    $mail->Body .= "http://localhost/ouvatech/src/confirm.php?email=$email&confirmationCode=$confirmationCode";
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        
    } else {
        echo 'Message sent!';
    }
    return true;
}

public function updateConfirmationStatus($email, $confirmationCode)
{
    
    $confirmationCode = $this->conn->real_escape_string($confirmationCode);
    $email = $this->conn->real_escape_string($email);
    
    // Check if the confirmation code belongs to the email
    $query = "SELECT * FROM users WHERE email='$email' AND confirmation_code='$confirmationCode'";
    $result = $this->conn->query($query);
    if (!$result || $result->num_rows == 0) {
        return false;
    }
    
    // Update the confirmation status
    $query = "UPDATE users SET confirmed=1 WHERE email='$email'";
    return $this->conn->query($query);
}


}
?>