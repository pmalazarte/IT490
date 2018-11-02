<?php
require ('rabbitmq/rabbitMQClient.php');

$first_name = $_POST['firstname'];
$last_name = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];

$json = doRegistration($first_name, $last_name, $email, $password);
$response = json_decode($json)
echo "doRegistration : $response".PHP_EOL;

if($response === false){
      echo "Registration failed, please try again";
      error_log("ERROR: Registration failed, please try again "), 3, "/var/www/html/errorlog.log");
      header("location:error.php");
}
else{
echo "Successfully created your account, please log in";
header("location:index.html");
}

?>