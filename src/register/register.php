<?php
include_once("./Registration.php");

if (isset($_POST['firstName'], $_POST['lastName'], $_POST['phoneNumber'], $_POST['email'], $_POST['password'], $_POST['confirmPassword'], $_POST['type'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $type = $_POST['type'];

    $requiredParams = array($firstName, $lastName, $phoneNumber, $email, $password, $confirmPassword, $type);

    // Check if any required parameter is empty
    if (in_array('', $requiredParams)) {
        header('Location: ../../error.php?registration=missing_params');
        exit; // Stop further execution
    }

    $account = new Registration($firstName, $lastName, $phoneNumber, $email, $password, $confirmPassword, $type);
    $account->register();

    if ($type === 'doctor') {
        header('Location: ../../doctorInfo.php?registration=successful');
    } else {
        header('Location: ../../userInfo.php?registration=successful');
    }
} 

if(isset($_GET['resend'])){
    session_start();
    $confirm = Registration::createWithoutParams();
    $confirm->resendActivationEmail($_SESSION['user_email']);
}


?>