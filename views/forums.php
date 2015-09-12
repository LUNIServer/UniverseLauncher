<?php
require_once('libraries/php-markdown-lib/MarkdownInterface.php');
require_once('libraries/php-markdown-lib/Markdown.php');
require_once('libraries/accounts.php');
use \Michelf\Markdown;
?>
		<div class="box">
			<h1 style="color:#000; margin: 0;">Forums</h1>
<?php
	if (isset($_POST['title']) && $_POST['title'] != "" && isset($_POST['submit']) && $_POST['submit'] == 'Submit Topic'){
		$sql = "INSERT INTO topics (name) VALUES ('" . $mysql->real_escape_string($_POST['title']) . "')";
		$mysql->query($sql);
	}
	
	$flag = false;
	if (isset($_GET['topic']) && is_numeric($_GET['topic'])){
		$topic_id = $_GET['topic'];
		$sql3 = "SELECT name FROM topics WHERE id = " . $topic_id;
		$res3 = $mysql->query($sql3);
		if ($res3 != NULL){
			$obj3=$res3->fetch_object();
			if (!empty($obj3->name)){
				$flag = true;
				
				$name = $_SESSION['user_name'];
				
				if (isset($_POST['text']) && $_POST['text'] != "" && isset($_POST['submit']) && ($_POST['submit'] == 'Submit Reply' || $_POST['submit'] == 'Submit Topic')){
					$sql = "INSERT INTO mails (subject, text, sender, recipient_id) VALUES ('Re: " . $obj3->name . "', '" . $mysql->real_escape_string($_POST['text']) . "', '" . $name . "', '" . $topic_id . "')";
					$mysql->query($sql);
				}
?>
			<h2 style="margin: 3px;">Topic: <?php echo $obj3->name; ?></h2>
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
				
				$per_page = 5;
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
				
				$sql_posts = "SELECT * FROM mails WHERE recipient_id = '" . $topic_id . "' LIMIT " . $offset . ", " . $per_page;
				$res_posts = $mysql->query($sql_posts);
				if ($res_posts != NULL){
					for ($k = 0; $k < $res_posts->num_rows; $k++){
						$obj_post = $res_posts->fetch_object();
?>
			<div class="forums-post">
				<div class="forums-post-header"><span class="num">#<?php echo $obj_post->id; ?></span> <?php echo $obj_post->sent_time . " - " . htmlspecialchars($obj_post->subject); ?></div>
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
						$my_html = Markdown::defaultTransform($obj_post->text);
						echo $my_html;
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
						<input type="submit" name="submit" value="Submit Reply">
						<br><br>
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
	
	if (!$flag){
		$sql = "SELECT topics.name, topics.id FROM topics";
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
					<div class="forums-post-text">
						<a href="?page=<?php echo $page . "&topic=" . $obj->id; ?>"><?php echo htmlspecialchars($obj->name); ?></a>
				
<?php
					$sql2 = "SELECT COUNT(id) as cnt FROM mails WHERE recipient_id = " . $obj->id;
					$res2 = $mysql->query($sql2);
					if ($res2 != NULL){
						$obj2 = $res2->fetch_object();
						echo " (" . $obj2->cnt . " Posts)";
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
			<form method="POST" class="wrapper-content" style="color: #FFF; padding: 10px 20px; display: flex;">
				<span style="flex: 1 1 20%;">Create new Topic: Name: </span>&nbsp;
				<input type="text" name="title" style="min-width: 50%; flex: 1 1 95%">&nbsp;
				<input type="submit" name="submit" value="Submit Topic" style="flex: 0 1 15%">
			</form>
			
	<?php } ?>
		</div>