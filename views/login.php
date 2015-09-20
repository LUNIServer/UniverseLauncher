		<div class="wrapper">
			<img src="img/u_hq2.png" style="width: 80%; margin: auto; display: block; margin-bottom: -8.2%;"/>
			<div class="wrapper-content">
				<div style="display: block; margin-bottom:5%; width: 100%;"></div>
				<form method="post" action="?" name="loginform">
					<div class="table" border="0" style="width: 100%;">
						<div class="table-row"><div class="table-cell">Username:</div><div class="table-cell"><input type="text" style="width: 100%" id="login_input_username" class="login_input" name="user_name" required /></div></div>
						<div class="table-row"><div class="table-cell">Password:</div><div class="table-cell"><input type="password" style="width: 100%" id="login_input_password" class="login_input" name="user_password" autocomplete="off" required /></div></div>
						<div class="table-row"><div class="table-cell"></div><div class="table-cell" style="text-align: right;"><input type="submit" name="login" value="LOGIN"/></div></div>
					</div>
				</form>
				<div style="font-size: 14pt; height: 25px;">
					<?php
					// show potential errors / feedback (from login object)
					if (isset($login)) {
						if ($login->errors) {
							foreach ($login->errors as $error) {
								echo $error;
							}
						}
						if ($login->messages) {
							foreach ($login->messages as $message) {
								echo $message;
							}
						}
					}
					?>
				</div>
			</div>
			<div class="wrapper-footer">
				<div><div style="display: flex"><span style="flex: 1 1 50%">&copy; 2015 LUNI Dev Team</span><a href="?page=register" style="flex: 1 1 50%; text-align: right; padding-right: 10px;">Register Account</a></div></div>
			</div>
			
		</div>