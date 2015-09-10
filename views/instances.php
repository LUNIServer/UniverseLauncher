<div class="box">
	<?php if (isset($_SESSION['rank']) && $_SESSION['rank'] > 1){ ?>
	<h1 style="color:#000; margin: 0;">Instances</h1>
	<br/>
	<table style="width: 100%;">
		<tr><th>Instance ID</th><th>Address</th></tr>
		<?php
			$sql = "SELECT `instanceid`, `server_address` FROM `instances`";
			$res = $mysql->query($sql);
			$c = $res->num_rows;
			for ($ca = 0; $ca < $c; $ca++){
				$obj = $res->fetch_object();
		?>
		<tr><td><?php echo $obj->instanceid; ?></td><td><?php echo $obj->server_address; ?></td></tr>
		<?php } ?>
	</table>
	
	<?php }else{ ?>
	<div class="alert">
		You are not allowed to access this page
	</div>
	<?php } ?>
</div>