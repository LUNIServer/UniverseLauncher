<?php require_once('libraries/accounts.php'); ?>
<div class="box pane">
	<?php if (isset($_SESSION['rank']) && $_SESSION['rank'] > 1){ 
		$return = updateUser($mysql);
	?>
	<h1 style="margin: 0;">Accounts</h1>
	<br/>
	<div style="display: inline-block; vertical-align: top; margin-bottom: 10px;">
		<table style="display: inline-table;">
			<tr><th>ID</th><th>Name</th><th>E-Mail</th><th>Rank</th><th>Locked</th><th>Banned</th><th>Actions</th></tr>
<?php
		$sql = "SELECT `id`, `name`, `email`, `rank`, `locked`, `banned` FROM `accounts`";
		$res = $mysql->query($sql);
		$accs = [];
		if ($res->num_rows){
			for ($i=0; $i < $res->num_rows; $i++){
				$obj = $res->fetch_object();
				$accs[$obj->name] = $obj;
?>			<tr><td><?php echo $obj->id;
	?></td><td><?php echo $obj->name;
	?></td><td><?php echo $obj->email;
	?></td><td><?php echo getRankName($obj->rank);
	?></td><td style="background-color: <?php if ($obj->locked > 0) echo "rgba(221,0,0,0.6)"; else echo "rgba(34,221,34,0.6)"; ?>;"><?php if ($obj->locked > 0) echo "YES"; else echo "NO";
	?></td><td style="background-color: <?php if ($obj->banned > 0) echo "rgba(221,0,0,0.6)"; else echo "rgba(34,221,34,0.6)"; ?>;"><?php if ($obj->banned > 0) echo "YES"; else echo "NO";
	?></td><td>
		<a href="?page=<?php echo $page; ?>&account=<?php echo $obj->name; ?>">Edit</a>
	</td></tr>
<?php
			}
		}
?>
		</table>
	</div>
	<?php 	if (isset($_GET['account']) && (preg_match("/^[A-Za-z0-9]*$/", $_GET['account']) == 1)) {
				$acc = $_GET['account'];
				if (isset($accs[$acc])){
	?>
	<div style="display: inline-block; vertical-align: top;">
		<form method="post" action="?page=<?php echo $page; ?>&account=<?php echo $acc; ?>">
			<table class="th-right tb-input">
				<tr><th style="text-align: center;">Key</th><th style="text-align: center;">Value</th></tr>
				<tr><th>ID</th><td style="font-size: 21px; padding: 3px;"><?php echo $accs[$acc]->id; ?><input type="hidden" name="id" value="<?php echo $accs[$acc]->id; ?>"/></td></tr>
				<tr><th>Name</th><td><input name="name" type="text" value="<?php echo $accs[$acc]->name; ?>"/><input type="hidden" name="name1" value="<?php echo $accs[$acc]->name; ?>"/></td></tr>
				<tr><th>E-Mail</th><td><input name="email" type="text" value="<?php echo $accs[$acc]->email; ?>"/></td></tr>
				<tr><th>Password</th><td><input name="password" type="password"/></td></tr>
				<tr><th>Repeat Password</th><td><input name="password-repeat" type="password"/></td></tr>
				<tr><th>Rank</th><td>
					<select name="rank">
						<option value="0"><?php echo getRankName(0); ?></option>
						<option value="1"<?php if ($accs[$acc]->rank == 1) echo " selected"; ?>><?php echo getRankName(1); ?></option>
						<option value="2"<?php if ($accs[$acc]->rank == 2) echo " selected"; ?>><?php echo getRankName(2); ?></option>
					</select>
				</td></tr>
				<tr><th>Locked</th><td><input id="lock_cb" name="locked" value="true" type="checkbox"<?php if ($accs[$acc]->locked > 0) echo " checked=\"true\""; ?>/><label for="lock_cb"></label></td></tr>
				<tr><th>Banned</th><td><input id="ban_cb" name="banned" value="true" type="checkbox"<?php if ($accs[$acc]->banned > 0) echo " checked=\"true\""; ?>/><label for="ban_cb"></label></td></tr>
				<tr><td colspan="2"><input type="submit" name="submit" value="Update" style="width: 100%;"/></td></tr>
				<?php if ($return != ""){ ?>
				<tr><td colspan="2" style="padding: 5px;"><?php echo $return; ?></td></tr>
				<?php } ?>
			</table>
		</form>
	</div>
	<?php 		}
			} ?>
	<?php
		}else{
	?>
	<div class="alert">
		You are not allowed to access this page
	</div>
	<?php } ?>
</div>