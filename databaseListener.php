#!/usr/bin/php
<?php
require_once('rabbitmq/path.inc');
require_once('rabbitmq/get_host_info.inc');
require_once('rabbitmq/rabbitMQLib.inc');

//submit query to Database
function loginUser($email,$password)
{
  global $mysql;
  $success = false;
  $emailEscaped = $mysql->escape_string($email);
  $passwordEscaped = $mysql->escape_string($password);
  $query = "SELECT * FROM users WHERE email='$emailEscaped' AND password='$passwordEscaped'";
  if ($result = $mysql->query($query))
  {
    if ($result->num_rows > 0) 
    {
      echo "Login Successful".PHP_EOL;
      $success = true;
    }
    else
    {
      echo "Login Failed".PHP_EOL;
      $success = false;
    }

    $result->close();
  }
  else
  {
    echo "User $email not found or password incorrect".PHP_EOL;
  }

  return json_encode($success);
}

//Validate login credentials match
function registerUser($firstname, $lastname, $password, $email)
{
  global $mysql;
  global $table;

  $success = false;
  $firstnameEscaped = $mysql->escape_string($firstname);
  $lastnameEscaped = $mysql->escape_string($lastname);
  $passwordEscaped = $mysql->escape_string($password);
  $emailEscaped = $mysql->escape_string($email);
  $query = "INSERT INTO $table (first_name, last_name, email, password)
            Values ('$firstnameEscaped', '$lastnameEscaped', '$passwordEscaped', '$emailEscaped')";
  
  if ($mysql->query($query) == TRUE) {
      echo "User '$firstname $lastname' registered successfully";
      $success = true;
  } else {
      echo "Could not register '$firstname $lastname'";
      $success = false;
      echo "Error: $mysql->error";	
  }

  return json_encode($success);
}

function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "Login":
      return loginUser($request['email'], $request['password']);
    case "Register":
      return registerUser($request['firstname'], $request['lastname'], $request['password'], $request['email']);
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed");
}

// Create the database and table if they don't exist
function initDataBase(&$conn)
{
  global $database;
  global $table;
  
  $sql = "CREATE DATABASE IF NOT EXISTS $database;";
  mysqli_query($conn, $sql);
  $conn->query($sql);
  $conn->select_db($database);
  
  $sql = "CREATE TABLE IF NOT EXISTS `$table` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`) 
  );";
  $conn->query($sql);
}

$table='users';
$database='accounts';
$serverName="localhost";
$username="IT490User";
$password="password";

//Connect to Database
//$mysql = mysqli_connect($serverName, $username, $password);
$mysql = new mysqli($serverName, $username, $password);
if (!$mysql) {
  echo "Error: Unable to connect to MySQL." . PHP_EOL;
  echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
  echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
  exit;
}
echo "mysql connect successful".PHP_EOL;

initDataBase($mysql);

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;

mysqli_close($mysql);
?>
