<?php
include_once("./Registration.php");
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phoneNumber = $_POST['phoneNumber'];
$email = $_POST['emailAddress'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm-password'];
$account = new Registration($firstName, $lastName, $phoneNumber, $email, $password, $confirmPassword);
$account->register();

?>