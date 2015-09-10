<?php
	require_once('libraries/pages.php');
	$page = 'dashboard';
	if (isset($_GET['page'])){
		$page = strtolower($_GET['page']);
	}
	$style = '';
	$mysql = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$mysql->set_charset("utf8");
	
?>		<div class="menu<?php if ($style != ''){ echo " " . $style; } ?>">
			<div class="logo pane"></div>
			<ul class="nav">
				<li><a class="button<?php echo isPage($page, 'dashboard'); ?>" href="?page=dashboard">Dashboard</a></li>
				<li><a class="button" href="?logout">Logout</a></li>
			</ul>
			<ul class="nav">
				<li><a class="button<?php echo isPage($page, 'char'); ?>" href="?page=char">Character</a></li>				
			</ul>
			<?php if (isset($_SESSION['rank']) && $_SESSION['rank'] > 1){ ?>
			<ul class="nav">
				<li><span class="button title">Administration</span></li>
				<li><a class="button<?php echo isPage($page, 'accounts'); ?>" href="?page=accounts">Accounts</a></li>
				<li><a class="button<?php echo isPage($page, 'characters'); ?>" href="?page=characters">Characters</a></li>
				<li><a class="button<?php echo isPage($page, 'instances'); ?>" href="?page=instances">Instances</a></li>
				<li><a class="button<?php echo isPage($page, 'sessions'); ?>" href="?page=sessions">Sessions</a></li>
			</ul>
			<?php } ?>
			<ul class="nav">
				<li><a class="button<?php echo isPage($page, 'help'); ?>" href="?page=Help">Help</a></li>
			</ul>
			<ul class="nav">
<?php
			if (!$mysql->connect_errno) {
		$sql = "SELECT `characters`.`name` as `charname` FROM `characters`, `accounts` WHERE `accounts`.`id` = `characters`.`accountID` AND `accounts`.`name` = '" . $_SESSION['user_name'] . "'";
		$result = $mysql->query($sql);
		$chars = [];
		if ($result->num_rows > 0){
			for ($i = 0; $i < $result->num_rows; $i++){
				$resobj = $result->fetch_object();
				$chars[] = $resobj->charname;
				if (isset($_GET['char_name'])){
					if ($_GET['char_name'] == $resobj->charname){
						$_SESSION['char_name'] = $resobj->charname;
					}
				}
			}
		}
		for ($i = 0; $i < count($chars); $i++){
			$char = $chars[$i];
			$f = true;
			if (isset($_SESSION['char_name'])){
				if ($_SESSION['char_name'] == $char){
					$f = false; ?>
				<li><span class="button" style="color: #000;"><?php echo $char; ?></span></li>
<?php 			}
			}
			if ($f){
?>				<li><a class="button" href="?page=<?php echo $page; ?>&char_name=<?php echo $char; ?>"><?php echo $char; ?></a></li>
<?php 		}
		}
	}
?>			</ul>
		</div>
		<div class="content-pane" style="padding-left: 180px; overflow: auto;">
			<div style="padding: 40px;">
<?php
	switch($page){
		case 'dashboard':
			include('views/dashboard.php');
			break;
		case 'char':
			include('views/char.php');
			break;
		case 'sessions':
			include('views/sessions.php');
			break;
		case 'accounts':
			include('views/accounts.php');
			break;
		case 'characters':
			include('views/characters.php');
			break;
		case 'instances':
			include ('views/instances.php');
			break;
		default:
			include('views/404.php');
	}
?>
			</div>
		</div>
		