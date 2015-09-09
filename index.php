<?php
	// include the configs / constants for the database connection
	require_once("config/db.php");

	// load the login class
	require_once("classes/Login.php");
	
	$login = new Login();
?><!DOCTYPE html>
<html style="min-width: 350px; background-image: url('img/bg.png'); overflow: hidden; height: 100%;">
	<head>
		<title>LUNIServer</title>
		<link rel="stylesheet" href="css/lu.css?a=0" type="text/css"/>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
	</head>
	<body style="overflow:auto; height: 100%; margin: 0;">
<?php 
	if (isset($_GET['page']) && $_GET['page'] == 'register'){
		require_once("classes/Registration.php");
		$registration = new Registration();
		include('views/register.php');
	}else{
		if ($login->isUserLoggedIn() != true) { 
			include('views/login.php');
		} else {
			include('views/pager.php');
		}
	}
	?>
	</body>
</html>