<?php
require_once('libraries/accounts.php');
require_once('libraries/forums.php');
?>
		<div class="box pane">
			<h1 style="margin: 0;">Forums</h1>
<?php
	$topic_id = -1;

	if (isset($_POST['title']) && $_POST['title'] != "" && isset($_POST['submit']) && $_POST['submit'] == 'Submit Topic'){
		$min_rank = 0;
		if (isset($_POST['min_rank']) && is_numeric($_POST['min_rank'])){
			$min_rank = (int) $_POST['min_rank'];
			if ($min_rank > $_SESSION['rank'] || $min_rank < 0){
				$min_rank = 0;
			}
		}
		$sql = "INSERT INTO topics (name, min_rank) VALUES ('" . $mysql->real_escape_string($_POST['title']) . "', '" . $min_rank . "')";
		
		$mysql->query($sql);
		$topic_id = $mysql->insert_id; 
	}
	
	$flag = false;
	if ((isset($_GET['topic']) && is_numeric($_GET['topic'])) || $topic_id > -1){
		if ($topic_id == -1) $topic_id = $_GET['topic'];
		$sql3 = "SELECT `name`, `min_rank` FROM topics WHERE id = " . $topic_id;
		$res3 = $mysql->query($sql3);
		if ($res3 != NULL){
			$obj3=$res3->fetch_object();
			if (!empty($obj3->name) && ($obj3->min_rank <= $_SESSION['rank'])){
				$flag = true;
				
				$name = $_SESSION['user_name'];
				
				if (isset($_POST['text']) && $_POST['text'] != "" && isset($_POST['submit']) && ($_POST['submit'] == 'Submit Reply' || $_POST['submit'] == 'Submit Topic')){
					$sql = "INSERT INTO mails (subject, text, sender, recipient_id) VALUES ('Re: " . $obj3->name . "', '" . $mysql->real_escape_string($_POST['text']) . "', '" . $name . "', '" . $topic_id . "')";
					$mysql->query($sql);
				}
?>
			<?php topicHeader($obj3->name, $obj3->min_rank); ?>
			<br>
<?php
				$taccounts = array();
				
				$sql_accounts = "SELECT accounts.email, accounts.name, accounts.rank FROM accounts, mails WHERE mails.recipient_id = '" . $topic_id . "' AND mails.sender = accounts.name";
				$res_accounts = $mysql->query($sql_accounts);
				if ($res_accounts != NULL){
					for ($k = 0; $k < $res_accounts->num_rows; $k++){
						$obj_account = $res_accounts->fetch_object();
						$md5 = "";
						if (!empty($obj_account->email)) $md5 = md5( strtolower( trim( $obj_account->email ) ) );
						$taccounts[$obj_account->name] = array('name' => $obj_account->name, 'mailhash' => $md5, 'rank' => $obj_account->rank);
					}
				}
				
				$per_page = 10;
				$cp = 0;
				if (isset($_GET['cp']) && is_numeric($_GET['cp'])){
					$cp = (int) $_GET['cp'];
				}
				
				$offset = $cp * $per_page;
				
				$comment_count = -1;
				
				$sql_post_count = "SELECT COUNT(*) as cnt FROM mails WHERE recipient_id = '" . $topic_id . "'";
				$res_post_count = $mysql->query($sql_post_count);
				if ($res_post_count != NULL){
					$obj_post_count = $res_post_count->fetch_object();
					$comment_count = $obj_post_count->cnt;
				}
				
				$page_count = -1;
				
				if ($comment_count > $per_page){
					$page_count = ((int)(($comment_count - 1) / $per_page)) + 1;
				}
				
				$sql_posts = "SELECT * FROM mails WHERE recipient_id = '" . $topic_id . "' ORDER BY `sent_time` LIMIT " . $offset . ", " . $per_page;
				$res_posts = $mysql->query($sql_posts);
				if ($res_posts != NULL){
					for ($k = 0; $k < $res_posts->num_rows; $k++){
						$obj_post = $res_posts->fetch_object();
?>
			<div class="forums-post">
				<?php postHeader($obj_post, $page) ?>
				<div class="forums-post-content">
					<div class="forums-post-author">
						<p>
							<?php
								if (isset($taccounts[$obj_post->sender])){
									//if(!empty($taccounts[$obj_post->sender]['mailhash'])){
?>							<img src="http://www.gravatar.com/avatar/<?php echo $taccounts[$obj_post->sender]['mailhash']; ?>?d=identicon" /><br><?php
									//}
?>
							<span><?php  echo getRankName($taccounts[$obj_post->sender]['rank']) ?></span><br>
<?php
								}
							?>
							<b><?php echo $obj_post->sender; ?></b>
						</p>
					</div>
					<div class="forums-post-text">
					<?php
						echo transform($obj_post->text);
					?>
					</div>
				</div>
			</div>
			<br>
<?php
					}
				}
?>		
			<form method="POST" class="forums-post">
				<div class="forums-post-header">Reply To: <?php echo $obj3->name; ?></div>
				<div class="forums-post-content">
					<div class="forums-post-text">
						<textarea name="text" style="width: 100%; box-sizing: border-box;"></textarea>
						<div style="text-align: right; padding-top: 5px;"><input type="submit" name="submit" value="Submit Reply"></div>
					</div>
				</div>
			</form>
			<br>
<?php
				$current = $cp + 1;
				if ($page_count > -1){
?><a class="pager<?php if ($current == 1) echo " current"; ?>" href="?page=<?php echo $page; ?>&topic=<?php echo $topic_id; ?>&cp=0"> 1 </a><?php
if ($page_count > 2) { ?> <a class="pager<?php if ($current == 2) echo " current"; ?>" href="?page=<?php echo $page; ?>&topic=<?php echo $topic_id; ?>&cp=1"> 2 </a><?php } 
if ($page_count > 4) {
	if ($current > 4) { ?> <a class="pager"> ... </a><?php }
	if ($current > 3 && $current < $page_count) { ?> <a class="pager" href="?page=<?php echo $page; ?>&topic=<?php echo $topic_id; ?>&cp=<?php echo $current - 2; ?>"> <?php echo $current - 1; ?> </a><?php }
	if ($current > 2 && $current < $page_count - 1) { ?> <a class="pager current" href="?page=<?php echo $page; ?>&topic=<?php echo $topic_id; ?>&cp=<?php echo $current - 1; ?>"> <?php echo $current; ?> </a><?php }
	if ($current > 1 && $current < $page_count - 2) { ?> <a class="pager" href="?page=<?php echo $page; ?>&topic=<?php echo $topic_id; ?>&cp=<?php echo $current; ?>"> <?php echo $current + 1; ?> </a><?php }
	if ($current < $page_count - 3) { ?> <a class="pager"> ... </a><?php }
}
if ($page_count > 3) { ?> <a class="pager<?php if ($current == $page_count - 1) echo " current"; ?>" href="?page=<?php echo $page; ?>&topic=<?php echo $topic_id; ?>&cp=<?php echo $page_count - 2; ?>"> <?php echo $page_count - 1; ?> </a><?php } 
if ($page_count > 1) { ?> <a class="pager<?php if ($current == $page_count) echo " current"; ?>" href="?page=<?php echo $page; ?>&topic=<?php echo $topic_id; ?>&cp=<?php echo $page_count - 1; ?>"> <?php echo $page_count; ?> </a><?php } 
				}
			}
		}
	}
	
	if (!$flag && isset($_GET['post']) && is_numeric($_GET['post'])){
		$id = (int) $_GET['post'];
		$sql = "SELECT * FROM `mails` WHERE `id` = '" . $id . "'";
		$res = $mysql->query($sql);
		if ($res != NULL && $res->num_rows > 0){
			$obj = $res->fetch_object();
			
			//ost exists
			$sql2 = "SELECT * FROM `topics` WHERE `id` = '" . $obj->recipient_id . "'";
			$res2 = $mysql->query($sql2);
			if ($res2 != NULL && $res2->num_rows > 0){
				$obj2 = $res2->fetch_object();
				if ($obj2->min_rank <= $_SESSION['rank']){
?>
			<?php topicHeader($obj2->name, $obj2->min_rank); ?>
			<br>
<?php
				$delete = false;
				if ($_SESSION['rank'] > 0){
					if (isset($_GET['action']) && $_GET['action'] == 'delete'){
						if(isset($_POST['delete']) && $_POST['delete'] == "confirm"){
						$sql5 = "DELETE FROM `mails` WHERE `id` = '" . $obj->id . "'";
						$mysql->query($sql5);
?>
			<span class="highlight">The following post has been deleted!</span><br>
<?php
						}else{
?>
			<span class="highlight">Please press confirm to delete the following post.</span><br>
<?php
							$delete = true;
						}
?>
			<br>
<?php
					}
				}
?>
			
			<div class="forums-post">
				<?php postHeader($obj, $page) ?>
				<div class="forums-post-content">
					<div class="forums-post-author">
						<?php
							$email = "";
							$hash = "";
							$rank = "UNKNOWN";
							$sql3 = "SELECT `email`, `rank` FROM `accounts` WHERE `name` = '" . $obj->sender . "'";
							$res3 = $mysql->query($sql3);
							if ($res != NULL && $res->num_rows > 0){
								$obj3 = $res3->fetch_object();
								$email = $obj3->email;
								$rank = getRankName($obj3->rank);
							}
							if ($email != "") $hash = md5(strtolower(trim( $email)));
						?>
						<p>
							<img src="http://www.gravatar.com/avatar/<?php echo $hash; ?>?d=identicon" /><br>
							<span><?php  echo $rank; ?></span><br>
							<b><?php echo $obj->sender; ?></b>
						</p>
					</div>
					<div class="forums-post-text">
<?php
						$text = $obj->text;
						$f2 = true;
						if ($_SESSION['rank'] > 0){
							if (isset($_POST['edit']) && $_POST['edit'] == 'update'){
								if (isset($_POST['text'])){
									$text = $_POST['text'];
									$sql4 = "UPDATE mails SET `text` = '" . $mysql->real_escape_string($text) . "' WHERE `id` = '" . $id . "'";
									$mysql->query($sql4);
								}
							}
							
							if (isset($_GET['action']) && $_GET['action'] == 'edit'){
								$f2 = false;
?>
						<form method="POST" action="?page=<?php echo $page; ?>&post=<?php echo $id; ?>">
							<textarea name="text" style="width: 100%; box-sizing: border-box;"><?php echo htmlspecialchars($obj->text); ?></textarea>
							<div style="text-align: right; padding-top: 5px;">
								<button name="edit" type="submit" value="update" style="height: 2em;">Update Post</button>
							</div>
						</form>
<?php
							}
						}
						
						if ($f2){
?>
						<div style="min-height: 100px;">
<?php
							echo transform($text);
?>
						</div>
<?php
							if ($delete){
?>
						<form method="POST" action="?page=<?php echo $page; ?>&post=<?php echo $id; ?>&action=delete" style="text-align: right; padding-top: 5px;">
							<button name="delete" type="submit" value="confirm" style="height: 2em;">Confirm Delete</button>&nbsp;
						</form>
<?php
							}
						}
?>
					</div>
				</div>
			</div>
<?php
				}else{
					echo "There is no post with the id " . $id;
				}
			}else{
				echo "There is no post with the id " . $id;
			}			
		}else{
			echo "There is no post with the id " . $id;
		}
		$flag = true;
	}
	
	if (!$flag){
		$sql = "SELECT name, id, min_rank FROM topics WHERE `min_rank` <= '" . $_SESSION['rank'] . "'";
		$res = $mysql->query($sql);
		if ($res != NULL){
			if ($res->num_rows > 0){
?>
			<br>
			<div class="forums-post">
				<div class="forums-post-header">
					Topics
				</div>
<?php
				for ($k = 0; $k < $res->num_rows; $k++){
					$obj = $res->fetch_object();
?>
				<div class="forums-post-blank">
					<div class="forums-post-text" style="display: flex;">
						<span style="flex: 1 1 100%;"><a href="?page=<?php echo $page . "&topic=" . $obj->id; ?>"><?php
						if ($obj->min_rank > 0){
							echo "[" . getRankName($obj->min_rank) . "S] ";
						}
						echo htmlspecialchars($obj->name); ?></a></span>
				
<?php
					$sql2 = "SELECT COUNT(id) as cnt, MAX(sent_time) as last FROM mails WHERE recipient_id = " . $obj->id;
					$res2 = $mysql->query($sql2);
					if ($res2 != NULL){
						$obj2 = $res2->fetch_object();
						?><span style="white-space: nowrap;">(<?php echo $obj2->cnt; ?> Posts<?php if ($obj2->last) { ?>, Last Post: <?php echo $obj2->last; } ?>)</span><?php
					}
?>
					</div>
				</div>
<?php
				}
			}else{
				echo "Currently no topics available";
			}
		}
	?>
				<br>
			</div>
			
			<br>
			<form method="POST" class="forums-post">
				<div class="forums-post-header" style="display: flex;">
					<span style="white-space: nowrap;">Create new topic:&nbsp;</span>
					<input type="text" name="title" style="flex: 1 1 100%;">
					<?php if ($_SESSION['rank'] > 0){ ?>
					<span style="white-space: nowrap;">&nbsp;Minimum Rank:&nbsp;</span>
					<select name="min_rank" style="width: 150px;">
						<option value="0" selected><?php echo getRankName(0); ?></option>
						<?php
							for ($p = 1; $p < $_SESSION['rank'] + 1; $p++){
						?>
						<option value="<?php echo $p; ?>"><?php echo getRankName($p); ?></option>
						<?php
							}
						?>
					</select>
					<?php } ?>
				</div>
				<div class="forums-post-content">
					<div class="forums-post-text">
						<textarea name="text" style="width: 100%; box-sizing: border-box; margin-bottom: 0px;"></textarea>
						<div style="text-align: right; padding-top: 5px;"><input type="submit" name="submit" value="Submit Topic"></div>
					</div>
				</div>
			</form>
			
	<?php } ?>
		</div>