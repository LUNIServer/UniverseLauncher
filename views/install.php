<html style="min-width: 350px; overflow: hidden;" class="themed sentinel">
	<head>
		<title>LUNIServer</title>
		<link rel="stylesheet" href="css/lu.css?a=0" type="text/css"/>
		<link rel="stylesheet" href="css/forums.css" type="text/css"/>
		<link rel="stylesheet" href="css/dashboard.css" type="text/css"/>
		<link rel="stylesheet" href="css/factions.css" type="text/css"/>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<style>
			.login_field{
				max-width: 100%;
			}
		</style>
	</head>
	<body style="overflow:auto; height: 100%; margin: 0;">
		<div class="wrapper">
			<div class="wrapper-header">
				Installing UniverseLauncher
			</div>
			<div class="wrapper-content">
<?php
					if (isset($_POST['install'])){
						$flag = true;
						if ($_POST['install'] == "Register"){
							if (isset($_POST['db_host']) && isset($_POST['db_db']) && isset($_POST['db_user']) && isset($_POST['db_pass'])){
								$host = $_POST['db_host'];
								$db = $_POST['db_db'];
								$user = $_POST['db_user'];
								$pass = $_POST['db_pass'];
								
								error_reporting(E_PARSE | E_ERROR);
								$mysql = new mysqli($host, $user, $pass, $db);
								error_reporting(E_PARSE | E_ERROR | E_WARNING);
								if ($mysql->connect_error){
									echo 'Connect Error (' . $mysql->connect_errno . ') ' . $mysql->connect_error;
								}else{
									$config = "<?php\n";
									$config .= "define(\"DB_HOST\", \"" . $host . "\");\n";
									$config .= "define(\"DB_NAME\", \"" . $db . "\");\n";
									$config .= "define(\"DB_USER\", \"" . $user . "\");\n";
									$config .= "define(\"DB_PASS\", \"" . $pass . "\");";
									
									file_put_contents("config/db.php", $config);
?>
				Successfully connected to the database you specified.<br><br>
				The configuration file has been written.
				<pre><?php echo htmlspecialchars($config); ?></pre>
									<a href="?">To Login</a>
<?php
									$flag = false;
								}
							}
						}
						
						if ($flag){
?>
				<form method="post" name="registerform" style="margin: 0;">

					<!-- the user name input field uses a HTML5 pattern check -->
					<label for="db_host">Host</label><br>
					<input id="db_host" class="login_field" type="text" name="db_host" required placeholder="localhost"/><br>

					<!-- the email input field uses a HTML5 email type check -->
					<label for="db_db">Database</label><br>
					<input id="db_db" class="login_field" type="textl" name="db_db" required placeholder="luni"/><br>

					<label for="db_user">Username</label><br>
					<input id="db_user" class="login_field" type="text" name="db_user" required placeholder="root"/><br>

					<label for="db_pass">Password</label><br>
					<input id="db_pass" class="login_field" type="password" name="db_pass" autocomplete="off" /><br>
					<div style="height: 3px;">&nbsp;</div>
					<span class="small">
					<?php
					// show potential errors / feedback (from registration object)
					if (isset($registration)) {
						if ($registration->errors) {
							foreach ($registration->errors as $error) {
								echo $error;
							}
						}
						if ($registration->messages) {
							foreach ($registration->messages as $message) {
								echo $message;
							}
						}
					}
					?>
					</span>
					<div style="text-align: right;"><input type="submit" name="install" value="Register" /></div>
				</form>
<?php
						}
					} else {
?>
				If you see this page in all it's glory, you have successfully downloaded and included "UniverseLauncher" in the right place.
				<br><br>
				However it seems that it's not configured yet.
				<br><br>
				<!--Go to <span style="color: #55F">UniverseLauncher/config</span> in your file system and open <span style="color: #55F">db.default.php</span>.<br>
				Change the values to match you LUNI Database and save the file as <span style="color: #55F">db.php</span>.
				<br><br>-->
				Follow this Setup-Wizard to configure your database connection.
				<form method="POST" style="margin: 0; text-align: right;">
					<button type="submit" name="install" value="Step 1">Next</button>
				</form>
				<?php
					}
				?>
			</div>
		</div>
		<div id="disclaimer">
			<span style="color: #F00;">NOTE:</span> The LEGO Group has not endorsed or authorized the operation of this game and is not liable for any safety issues in relation to the operation of this game.
		</div>
	</body>
</html>