<?php
// Include the Login class file
require_once('./login.php');
// Create a new Login object
session_start();
$login = new Login();

if(isset($_SESSION['user_id'], $_POST['old-pass'])){

}
?>