<div class="box pane">
	<?php if (isset($_SESSION['rank']) && $_SESSION['rank'] > 1){ ?>
	<h1 style="margin: 0;">Characters</h1>
	<br/>
	<?php
		if (isset($_GET['approve_id']) && preg_match("/^[0-9]*$/", $_GET['approve_id']) == 1){
			$id = $_GET['approve_id'];
			$name_sql = "SELECT `unapprovedName` as `uname` FROM `characters` WHERE `objectID` = '" . $id . "' AND `unapprovedName` <> '';";
			$name_res = $mysql->query($name_sql);
			if ($name_res == NULL) echo $mysql->error;
			if ($name_res->num_rows > 0){
				$name_obj = $name_res->fetch_object();
				$update = "UPDATE `characters` SET `name` = '" . $name_obj->uname . "', `unapprovedName` = '' WHERE `objectID` = '" . $id . "';";
				$update_res = $mysql->query($update);
				if ($update_res == NULL) echo $mysql->error; else echo "Name Accepted<br>\n";
			}
		}
		
		if (isset($_GET['decline_id']) && preg_match("/^[0-9]*$/", $_GET['decline_id']) == 1){
			$id = $_GET['decline_id'];
			$update = "UPDATE `characters` SET `unapprovedName` = '' WHERE `objectID` = '" . $id . "';";
			$update_res = $mysql->query($update);
			if ($update_res == NULL) echo $mysql->error; else echo "Name Declined<br>\n";
		}
	?>
	
	<table>
		<tr><th>Account</th><th>Name</th><th>Unapproved Name</th></tr>
	<?php 
		$sql = "SELECT `accounts`.`name` as `aname`, `characters`.`name`, `characters`.`unapprovedName` as `uname`, `characters`.`objectID` FROM `accounts`, `characters` WHERE `characters`.`accountID` = `accounts`.`id` ORDER BY `accounts`.`name`;";
		$res = $mysql->query($sql);
		if ($res == NULL){
			echo $mysql->error;
		}
		$c = $res->num_rows;
		for ($ca = 0; $ca < $c; $ca++){
			$obj = $res->fetch_object(); ?>
		<tr>
			<td><?php echo $obj->aname; ?></td>
			<td><?php echo $obj->name; ?></td>
			<td><?php echo $obj->uname; ?></td>
			<?php if ($obj->uname != ""){ ?>
			<td><a href="?page=<?php echo $page; ?>&approve_id=<?php echo $obj->objectID; ?>">Approve</a></td>
			<td><a href="?page=<?php echo $page; ?>&decline_id=<?php echo $obj->objectID; ?>">Decline</a></td>
			<?php } ?>
		</tr><?php
		}
	?>
	</table>
	<?php }else{ ?>
	<div class="alert">
		You are not allowed to access this page
	</div>
	<?php } ?>
</div>