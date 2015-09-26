<?php
	// include the configs / constants for the database connection
	if (file_exists("config/db.php")){
		require_once("config/db.php");
		
		// load the login class
		require_once("classes/Login.php");
		
		$login = new Login();
		
		if (!isset($_SESSION['theme'])) $_SESSION['theme'] = "";
		if ($login->isUserLoggedIn()){
			if (isset($_POST['theme'])){
				if ($_POST['theme'] == "assembly") $_SESSION['theme'] = "assembly";
				if ($_POST['theme'] == "paradox") $_SESSION['theme'] = "paradox";
				if ($_POST['theme'] == "sentinel") $_SESSION['theme'] = "sentinel";
				if ($_POST['theme'] == "ventureleague") $_SESSION['theme'] = "ventureleague";
				if ($_POST['theme'] == "nexus") $_SESSION['theme'] = "";
			}
			$theme = $_SESSION['theme'];
		}else{
			$theme = "sentinel";
		}
?><!DOCTYPE html>
<html style="min-width: 350px; overflow: hidden;" class="themed<?php if ($theme != "") echo " " . $theme; ?>">
	<head>
		<title>LUNIServer</title>
		<link rel="stylesheet" href="css/lu.css?a=0" type="text/css"/>
		<link rel="stylesheet" href="css/forums.css" type="text/css"/>
		<link rel="stylesheet" href="css/dashboard.css" type="text/css"/>
		<link rel="stylesheet" href="css/factions.css" type="text/css"/>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	</head>
	<body class="themed-background" style="overflow:auto; height: 100%; margin: 0;">
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
<div id="disclaimer">
			<span style="color: #F00;">NOTE:</span> The LEGO Group has not endorsed or authorized the operation of this game and is not liable for any safety issues in relation to the operation of this game.
		</div>
	</body>
</html>
<?php } else {
	include("views/install.php");
} ?>
