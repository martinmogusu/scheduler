<?php

// DB connection config
$server = "localhost";
$db_name = "euss";
$db_user = "root";
$db_password = "";

$con = new mysqli($server, $db_user, $db_password, $db_name);

if($con->connect_error){
  echo "DB Connection Failed - " . $con->connect_error . "<br>";
} else {
  // Connection successful
}

?>