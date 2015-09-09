<?php require_once('libraries/sessions.php'); ?>
<div class="box">
	<?php if (isset($_SESSION['rank']) && $_SESSION['rank'] > 1){ ?>
	<h1 style="color:#000; margin: 0;">Sessions</h1>
	<br/>
	<table>
		<tr><th>Instance</th><th>Client</th><th>Phase</th><th>Name</th><th>Character</th><th>Zone</th></tr>
<?php
	$sql = "SELECT `instanceid`, `ipaddress`, `phase`, `accountid`, `charid`, `zoneid` FROM `sessions`";
	$res = $mysql->query($sql);
	$c = $res->num_rows;
	for ($ca = 0; $ca < $c; $ca++){
		$obj = $res->fetch_object();
?>
		<tr><td><?php echo $obj->instanceid; ?></td><td><?php echo $obj->ipaddress; ?></td><td><?php echo getSessionPhaseName($obj->phase); ?></td><td><?php
		$sql2 = "SELECT `name` FROM `accounts` WHERE `id` = '" . $obj->accountid . "';";
		$res2 = $mysql->query($sql2);
		if ($res2->num_rows > 0){
			$obj2 = $res2->fetch_object();
			?><?php echo $obj2->name; ?><?php
		}
		?></td><td><?php
		$sql3 = "SELECT `name` FROM `characters` WHERE `objectID` = '" . $obj->charid . "';";
		$res3 = $mysql->query($sql3);
		if ($res3->num_rows > 0){
			$obj3 = $res3->fetch_object();
			?><?php echo $obj3->name; ?><?php
		}
		?></td><td><?php
		if ($obj->zoneid > 0){
			echo getZoneDesc($obj->zoneid) . " (" . $obj->zoneid . ")";
		}
		?></td></tr>
<?php } ?>
	</table>
	<?php }else{ ?>
	<div class="alert">
		You are not allowed to access this page
	</div>
	<?php } ?>
</div>