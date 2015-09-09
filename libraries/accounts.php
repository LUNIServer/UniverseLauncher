<?php
	function getRankName($rankid){
		switch($rankid){
			case 0:
				return "REGULAR";
			case 1:
				return "MODERATOR";
			case 2:
				return "ADMIN";
			default:
				return "HACKER?";
		}
	}
	
	function updateUser($mysql){
		$return = "";
		if (isset($_POST['submit'])){
			if (isset($_POST['id']) && preg_match("/^[0-9]*$/", $_POST['id'])){
				$sql = "UPDATE accounts SET ";
				$uFlag = false;
				$user_id = $_POST['id'];
				$user_name = "";
				$user_email = "";
				$user_newpassword = "";
				$user_rank = 0;
				$user_locked = false;
				$user_banned = false;
				$flag = false;
				//$return .= "Id: " . $user_id . "<br>\n";
				if (isset($_POST['name']) && !empty($_POST['name'])){
					if(preg_match("/^[A-Za-z0-9._]*$/", $_POST['name']) == 1){
						//$return .= "Name: " . $_POST['name'] . "<br>\n";
						$user_name = $_POST['name'];
						if ($uFlag) $sql .= ", ";
						$sql .= "`name` = '" . $user_name . "'";
						$uFlag = true;
						$flag = true;
					}else{
						$return .= "Incorrect name syntax<br>\n";
					}
				}else{
					$return .= "No name specified<br>\n";
				}
				if (isset($_POST['email'])){
					if(preg_match("/^[A-Za-z0-9._]*@[A-Za-z0-9.]*$/", $_POST['email']) == 1 || $_POST['email'] == ""){
						//$return .= "E-Mail: " . $_POST['email'] . "<br>\n";
						if ($uFlag) $sql .= ", ";
						$user_email = $_POST['email'];
						$sql .= "`email` = '" . $user_email . "'";
						$uFlag = true;
					}else{
						$return .= "Incorrect E-Mail syntax<br>\n";
						$flag = false;
					}
				}else{
					//echo "No E-mail specified<br>\n";
				}
				
				if(isset($_POST['password']) && !empty($_POST['password'])){
					if (preg_match("/^[A-Za-z0-9._]*$/", $_POST['password']) == 1){
						if (isset($_POST['password-repeat'])){
							if ($_POST['password-repeat'] == $_POST['password']){
								$user_newpassword = $_POST['password'];
								if ($uFlag) $sql .= ", ";
								$sql .= "`password` = '" . md5($user_newpassword) . "'";
								//$return .= "New Password: " . $user_newpassword . "<br>";
								$uFlag = true;
							}else{
								$return .= "Repeated Password does not match<br/>";
							}
						}
					}else{
						$return .= "Invalid Password<br>\n";
					}
				}else{
					//No password specified
				}
			
				if (isset($_POST['rank']) && preg_match("/^[0-9]*$/", $_POST['rank']) == 1){
					if ($uFlag) $sql .= ", ";
					$user_rank = (int) $_POST['rank'];
					$uFlag = true;
					$sql .= "`rank` = '" . $user_rank . "'";
					//$return .= "Rank: " . getRankName($user_rank) . "<br>";
				}
				
				if (isset($_POST['locked']) && $_POST['locked'] == 'true'){
					$user_locked = true;
					//$return .= "User Locked<br>";
				}
				
				if ($uFlag) $sql .= ", ";
				$uFlag = true;
				$sql .= "`locked` = ";
				if ($user_locked) $sql .= "TRUE"; else $sql .= "FALSE";
								
				
				if (isset($_POST['banned']) && $_POST['banned'] == 'true'){
					$user_banned = true;
					//$return .= "User Banned<br>";
				}
				
				if ($uFlag) $sql .= ", ";
				$uFlag = true;
				$sql .= "`banned` = ";
				if ($user_banned) $sql .= "TRUE"; else $sql .= "FALSE";
				
				$sql .= " WHERE `id` = '" . $user_id . "';";
				$mysql->query($sql);
				//$return .= $sql;
			}
		}
		return $return;
	}
?>