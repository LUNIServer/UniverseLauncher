				<div class="box">
		<?php
		if (isset($_SESSION['char_id'])){
		?>
			<h1 style="color:#000; margin: 0;">Mail</h1>
		<?php
				$sql = "SELECT * FROM `mails` WHERE `recipient_id` = '" . $_SESSION['char_id'] . "';";
				$res = $mysql->query($sql);
				if ($res == NULL){
					//Error
				}else{
					for ($k = 0; $k < $res->num_rows; $k++){
						$obj = $res->fetch_object();
		?>
			<br>
					<div style="background-color: #FFF; color: #000; border-radius: 15px; padding: 30px;">
						<pre style="margin: 0;">
<?php echo "DATE:    " . $obj->sent_time; ?>
						
<?php echo "FROM:    " . htmlspecialchars($obj->sender); ?>

<?php echo "SUBJECT: " . htmlspecialchars($obj->subject); ?>
<br>
<?php echo htmlspecialchars($obj->text); ?></pre>
					</div>
		<?php
					}
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
