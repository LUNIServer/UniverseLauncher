<!DOCTYPE html>
<html class="mythran">
	<head>
		<title>LUNIServer - LEGO Universe, Newly Imagined</title>
		<link rel="stylesheet" href="css/lu.css?launcher=1" type="text/css"/>
	</head>
	<body style="overflow:hidden;">
		<div style="position: relative">
			<div class="left">
				<div class="box">
					<h3>Welcome to LUNI:</h3><h4>LEGO Universe, Newly Imagined!</h4>
				</div>
				
				<div class="alert bottom">
					<h4 style="color: #FF0000;">NOTE: Be aware that this server is in EARLY development.</h4>
				</div>
			</div>
			<p style="position: fixed; bottom: 0; width: 100%; text-align: center; color: #444;">
				<a href="launcher.php?launcher=1">HOME</a>
			</p>
			<div class="right box">
				<h3>Changelog</h3>
				<hr/>
				<pre class="changelog">
<?php
	$file = file_get_contents('changelog.txt');
	echo $file;
				?></pre>
				<a class="btn fixed-bottom" href="changelog.php" target="_blank"><span>Full Changelog</span></a>
			</div>
		</div>
	</body>
</html>