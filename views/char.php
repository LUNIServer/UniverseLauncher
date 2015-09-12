		<div class="box">
<?php
	if (isset($_SESSION['char_id'])){
		$sql = "SELECT `name`, `objectID`, `unapprovedName`, `lastZoneId`, `mapInstance`, `mapClone`, `x`, `y`, `z` FROM `characters` WHERE `objectID` = '" . $_SESSION['char_id'] . "'";
		$res = $mysql->query($sql);
		if ($res->num_rows > 0){
			$obj = $res->fetch_object();
			$objid = $obj->objectID;
			$uname = $obj->unapprovedName;
			$name = $obj->name;
?>
		<h1 style="color:#000; margin: 0;"><?php echo $name . " "; if ($uname != "") echo "(" . $uname . ") "?></h1>
		<h3>[ObjectID: <?php echo $objid; ?>]</h3>
		<br/>
		<span>Zone: <?php echo $obj->lastZoneId; ?>, Instance: <?php echo $obj->mapInstance; ?>, Clone: <?php echo $obj->mapClone; ?>, Position: (<?php echo $obj->x . "|" . $obj->y . "|" . $obj->z; ?>)</span><br/>
		<span style="font-size: 9pt; color: #B00;">This position is only updated on world change at the moment</span>
<?php
		}
	}else{
?>
			<div class="alert">
				To use this page, please select a character from the menu on the left
			</div>
<?php
	}
?>
		</div>