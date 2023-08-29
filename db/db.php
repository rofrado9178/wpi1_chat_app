<?php

$host = "localhost";
$user = "user";
$password = "PleskDB1234";
$db_name = "wpi1_chat_app";

$db = mysqli_connect($host, $user, $password, $db_name);

$db->set_charset("utf8mb4");

if($db->connect_error){
  die('Connection Error ('.$db->connect_errno.')'.$db->connect_error);
}


?>