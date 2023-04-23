<?php
// Include the Login class file
require_once('./login.php');
// Create a new Login object
session_start();
$login = new Login();

// Check if the login form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['token'])) {
    // Call the login method and pass in the email, password, and token
    $login->login($_POST['email'], $_POST['password'], $_POST['token']);
    echo $_SESSION['user_id'];
}
?>
