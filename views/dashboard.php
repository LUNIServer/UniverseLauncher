			<div class="widget box">
				<h3 style="padding-bottom: 5px;">Server Status</h3>
				<?php
					$sql = "SELECT COUNT(name) as cnt FROM accounts;";
					$res = $mysql->query($sql);
					if ($res != NULL){
						$obj = $res->fetch_object();
						echo "<b>Accounts</b>: " . $obj->cnt . "<br>\n";
					}
				?>
				<br>
				<?php
					$sql = "SELECT COUNT(sessionid) as cnt FROM sessions;";
					$res = $mysql->query($sql);
					if ($res != NULL){
						$obj = $res->fetch_object();
						echo "<b>Player</b>: " . $obj->cnt . "<br>\n";
					}
					$sql = "SELECT COUNT(instanceid) as cnt FROM instances;";
					$res = $mysql->query($sql);
					if ($res != NULL){
						$obj = $res->fetch_object();
						echo "<b>Instances</b>: " . $obj->cnt . "<br>\n";
					}
					
				?>
			</div>
			<div class="widget box">
				<h3 style="padding-bottom: 5px;">Staff</h3>
				<?php
					$sql = "SELECT name FROM accounts WHERE rank > 1;";
					$res = $mysql->query($sql);
					if ($res != NULL){
						if ($res->num_rows > 0) echo "<b>Admins</b>: <br>\n";
						while ($obj = $res->fetch_object()){
							echo $obj->name . "<br>\n";
						}
					}
				?>
				<?php
					$sql = "SELECT name FROM accounts WHERE rank = 1;";
					$res = $mysql->query($sql);
					if ($res != NULL){
						if ($res->num_rows > 0) echo "<b>Moderators</b>: <br>\n";
						while ($obj = $res->fetch_object()){
							echo $obj->name . "<br>\n";
						}
					}
				?>
			</div>
			<!--<div class="widget box">
				Widget 1
			</div>
			<div class="widget box">
				Widget 1
			</div>
			<div class="widget box">
				Widget 1
			</div>
			<div class="widget box">
				Widget 1
			</div>
			<div class="widget box">
				Widget 1
			</div>-->
			