<?php
//set an error if there is an error
 ini_set("display_errors", "1");
 ini_set("display_startup_errors", "1");
 error_reporting(E_ALL);

 //credentials
$host = "localhost:3306";
$user = "fransiskus42_chat_app";
$password = "PleskDB1234";
$db_name = "fransiskus42_chat_app";

//setup db connection
$db = mysqli_connect($host, $user, $password, $db_name);

$db->set_charset("utf8mb4");

//if there is an error set an error
if($db->connect_error){
  die('Connection Error ('.$db->connect_errno.')'.$db->connect_error);
}
// echo "It Works";


?>