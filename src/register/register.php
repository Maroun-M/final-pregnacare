<?php
include_once("./Registration.php");
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['emailAddress'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm-password'];
$type = $_POST['registration-type'];

$account = new Registration($firstName, $lastName, $phoneNumber, $email, $password, $confirmPassword, $type);
$account->register();
if($type === 'doctor'){
    header('Location: ../../doctorInfo.php?registration=successful');
} else {
    header('Location: ../../userInfo.php?registration=successful');

}

?>