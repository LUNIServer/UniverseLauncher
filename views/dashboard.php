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
				<h3 style="padding-bottom: 5px;">Server Staff</h3>
				<?php
					$sql = "SELECT name FROM accounts WHERE rank > 1;";
					$res = $mysql->query($sql);
					if ($res != NULL){
						if ($res->num_rows > 0) echo "<b>Admins</b>: <br>\n";
						echo "<ul style=\"margin: 0;\">\n";
						while ($obj = $res->fetch_object()){
							echo "<li>" . $obj->name . "</li>\n";
						}
						echo "</ul>\n";
					}
				?>
				<?php
					$sql = "SELECT name FROM accounts WHERE rank = 1;";
					$res = $mysql->query($sql);
					if ($res != NULL){
						if ($res->num_rows > 0) echo "<b>Moderators</b>: <br>\n";
						echo "<ul style=\"margin: 0;\">\n";
						while ($obj = $res->fetch_object()){
							echo "<li>" . $obj->name . "</li>\n";
						}
						echo "</ul>\n";
					}
				?>
			</div>
			<div class="widget box">
				<h3 style="padding-bottom: 5px;">Links</h3>
				<b>LUNI:</b>
				<ul style="margin: 0;">
					<li><a href="http://luniserver.com/">LUNI Website</a></li>
					<li><a href="https://github.com/dsuser97/LUNI-Latest-Dev/">LUNI Github</a></li>
					<li><a href="http://luni.wikia.com">LUNI Wikia</a></li>
					<li><a href="http://luni-wiki.wikispaces.com">LUNI Wikispaces</a></li>
				</ul>
				<b>Docs:</b>
				<ul style="margin: 0;">
					<li><a href="https://docs.google.com/document/d/1v9GB1gNwO0C81Rhd4imbaLN7z-R0zpK5sYJMbxPP3Kc">Packet Docs</a></li>
				</ul>
			</div>
			<div class="widget box">
				<h3 style="padding-bottom: 5px;">LUNI Credits</h3>
				<b>Original Project:</b><br>
				Created by raffa505<br>
				<a href="http://sourceforge.net/projects/luniserver/">luniserver.sf.net</a><br>
				<br>
				<h3 style="padding-bottom: 5px;">LUNI License</h3>
				LUNI is licensed under the <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/">CC BY-NC-SA 4.0</a> License
			</div>
			<div class="widget box" style="background-color: #BCB;">
				<form method="POST">
					<div style="display: flex">
						<input type="submit" name="theme" value="assembly" class="assembly logo widget-logo pane" style="border-top-left-radius: 10px;"/>
						<input type="submit" name="theme" value="sentinel" class="sentinel logo widget-logo pane" style="border-top-right-radius: 10px;"/>
					</div>
					<div style="display: flex">
						<input type="submit" name="theme" value="ventureleague" class="ventureleague logo widget-logo pane" style="border-bottom-left-radius: 10px;"/>
						<input type="submit" name="theme" value="paradox" class="paradox logo widget-logo pane" style="border-bottom-right-radius: 10px;"/>
					</div>
					<input type="submit" name="theme" value="nexus" class="pane nexus logo widget-logo" style=""/>
				</form>
			</div>
			<!--<div class="widget box">
				Widget 1
			</div>
			<div class="widget box">
				Widget 1
			</div>-->
			