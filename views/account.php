		<div class="box pane">
			<h1 style="margin: 0;">Account</h1>
			
<?php
	if (isset($_GET['name']) && $_GET['name'] != $_SESSION['user_name'] && (preg_match("/^[0-9A-Za-z]+$/", $_GET['name']) == 1)){
		$user = $_GET['name'];
		$sql = "SELECT * FROM `accounts` WHERE `name` = '" . $user . "'";
		$res = $mysql->query($sql);
		if ($res != NULL){
			if ($res->num_rows > 0){
				$obj = $res->fetch_object();
				$hash = "";
				if ($obj->email != "") $hash = md5(strtolower(trim( $obj->email)));
?>
			<br>
			<div style="float:left">
				<img src="http://www.gravatar.com/avatar/<?php echo $hash; ?>?d=identicon" /><br>
			</div>
			<div style="font-size: 150%; padding-left: 100px;">
				<span style="min-width: 5.5em; display: inline-block;">Name: </span>
				<?php echo $obj->name; ?>
			</div>
<?php
			}
		}
	}else{
		$updated = false;
		if (isset($_POST['update']) && $_POST['update'] == "Update Account"){
			$uFlag = false;
			$return = "";
			$sql = $sql = "UPDATE accounts SET ";
			
			if (isset($_POST['email'])){
				if(preg_match("/^[A-Za-z0-9._]*@[A-Za-z0-9.]*$/", $_POST['email']) == 1 || $_POST['email'] == ""){
					if ($uFlag) $sql .= ", ";
					$user_email = $_POST['email'];
					if ($user_email != $_SESSION['user_email']){
						$sql .= "`email` = '" . $user_email . "'";
						$_SESSION['user_email'] = $user_email;
						$uFlag = true;
					}
				}else{
					$return .= "Incorrect E-Mail syntax<br>\n";
				}
			}
			
			if(isset($_POST['password']) && !empty($_POST['password'])){
				if (preg_match("/^[A-Za-z0-9._]*$/", $_POST['password']) == 1){
					if (isset($_POST['password-repeat'])){
						if ($_POST['password-repeat'] == $_POST['password']){
							$user_newpassword = $_POST['password'];
							if ($uFlag) $sql .= ", ";
							$sql .= "`password` = '" . md5($user_newpassword) . "'";
							$uFlag = true;
						}else{
							$return .= "Repeated Password does not match<br/>";
						}
					}
				}else{
					$return .= "Invalid Password<br>\n";
				}
			}
			
			$sql .= " WHERE `id` = '" . $_SESSION['user_id'] . "';";
			
			if ($uFlag){
				$mysql->query($sql);
			}
			$updated = true;
		}
?>
			<form method="POST" style="font-size: 150%;">
				<span style="min-width: 5.5em; display: inline-block;">Name: </span>
				<?php echo $_SESSION['user_name']; ?><br>
				<div style="height: 0.2em;"></div>
				<span style="min-width: 5em; display: inline-block;">E-Mail: </span>
				<input name="email" style="width: 20em; max-width: 100%;" type="email" value="<?php echo $_SESSION['user_email']; ?>"/><br>
				<div style="height: 0.2em;"></div>
				<span style="min-width: 5em; display: inline-block;">Password: </span>
				<input name="password" style="width: 20em; max-width: 100%;" type="password" value=""/><br>
				<div style="height: 0.2em;"></div>
				<span style="min-width: 5em; display: inline-block;"></span>
				<input name="password-repeat" style="width: 20em; max-width: 100%;" type="password" value=""/><br>
				<div style="height: 0.2em;"></div>
				<div style="text-align: right;">
					<?php if ($updated) echo "Account Updated!"; ?>&nbsp;&nbsp;<input style="float:none; max-width: 100%;" type="submit" name="update" value="Update Account"/>
				</div>
			</form>
		</div>
<?php } ?>