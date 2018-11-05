<?php
require ('rabbitmq/rabbitMQClient.php');

$email = $_POST['email'];
$password = $_POST['password'];

echo "email = $email".PHP_EOL;
echo "password = $password".PHP_EOL;

$json = doLogin($email, $password);
$response = json_decode($json);
echo "doLogin: $response".PHP_EOL;

if($response === false){
      echo "Login failed, please try again";
      error_log("ERROR: Login failed, please try again ", 3, "/var/www/html/errorlog.log");
      header("location:error.php");
}

else{
echo "Successfully logged in to your account";
header("location:profile.php");
}

?>
