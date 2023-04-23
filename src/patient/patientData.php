<?php

include_once("./updateUserInfo.php");
if($patient->checkID($_SESSION['user_id'])){
    $json_data = json_encode($patient->getAllInfo());
    header('Content-Type: application/json');
    echo $json_data;

}
?>