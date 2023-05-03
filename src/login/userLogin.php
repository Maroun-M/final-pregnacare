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

}
if(isset($_SESSION['user_id'])){
    $access_lvl = $login->getUserAccessLevel($_SESSION['user_id']);
    echo $access_lvl;
    if ($access_lvl == 1) { // Check if the user is logged in
        // User is logged in, redirect them to the home page or any other page
        header("Location: ../../patientMainMenu.php");
    } else if ($access_lvl == 2) {
        header("Location: ../../doctorMainMenu.php");
    }
}
if (isset($_POST['confirmation-email']) && isset($_POST['confirmation-code'])) {
    echo $_POST['confirmation-email'];
    echo $_POST['confirmation-code'];
    $login->confirmUser($_POST['confirmation-email'], $_POST['confirmation-code']);
}

if (isset($_GET['email']) && isset($_GET['confirmationCode'])) {
    $login->confirmUser($_GET['email'], $_GET['confirmationCode']);
}
?>