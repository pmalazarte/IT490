<?php 
session_start();
session_unset();
session_destroy();
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Weather Logout</title>
	<link rel="stylesheet" 
href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" 
crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="form">
    	<h1>You have logged out successfully</h1>
    	<a href="index.html"><button class="btn btn-secondary btn-lg btn-block"/>Home</button></a>
    </div>

</body>
</html>