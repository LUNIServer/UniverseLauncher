<?php
require_once('libraries/php-markdown-lib/MarkdownInterface.php');
require_once('libraries/php-markdown-lib/Markdown.php');
use \Michelf\Markdown;

	function transform($mysql, $text){
		//Transforms a mardown text to LUNI flavored HTML
		$text = linkUsers($mysql, $text);
		$my_html = Markdown::defaultTransform($text);
		return $my_html;
	}
	
	function linkUsers($mysql, $source){
		$matches = array();
		preg_match_all("/\@([A-Za-z0-9]+)/", $source, $matches);
		$users = array_unique($matches[1]);
		foreach ($users as $user){
			$sql = "SELECT * FROM `accounts` WHERE `name` = '" . $user . "'";
			$res = $mysql->query($sql);
			if ($res != NULL){
				if ($res->num_rows > 0){
					$source = str_replace("@" . $user, "[&#64;" . $user . "](?page=account&name=" . $user . ")", $source);
				}
			}
		}
		return $source;
	}
	
	/*
		This function returns the link to the avatar a user has depending on the hash of it's email address.
		You may enable any of the options below
	*/
	function getAvatarLink($hash){
	//Use this option to use gravatar with local avatars as default (doesn't work when accessed from localhost	
		//$dir = dirname($_SERVER["SCRIPT_NAME"]);
		//if ($dir == "\\") $dir = "";
		//$d = urlencode("http://" . $_SERVER["SERVER_NAME"] . $dir . "/img/avatar/" . $hash . ".png");
		//return "http://www.gravatar.com/avatar/" . $hash . "?d=" . $d;
	//Use this option for gravatar with identicons as default
		return "http://www.gravatar.com/avatar/" . $hash . "?d=identicon";
	//Use this option for ONLY local avatars
		//return "img/avatar/" . $hash . ".png";
	}
	
	function postHeader($post, $page){
?><div id="post-<?php echo $post->id; ?>" class="forums-post-header">
	<span class="num">#<?php echo $post->id; ?></span>
	<span style="flex: 1 1 50%;">&nbsp;<?php echo $post->sent_time . " - " . htmlspecialchars($post->subject); ?></span>
	<span style="text-align: right;">
		<?php if ($_SESSION['rank'] > 0) { ?>
		<a href="?page=<?php echo $page; ?>&topic=<?php echo $post->recipient_id; ?>">TOPIC</a>
		<a href="?page=<?php echo $page; ?>&post=<?php echo $post->id; ?>">VIEW</a>
		<a href="?page=<?php echo $page; ?>&post=<?php echo $post->id; ?>&action=edit">EDIT</a>
		<a href="?page=<?php echo $page; ?>&post=<?php echo $post->id; ?>&action=delete">DELETE</a>&nbsp;
		<?php } ?>
	</span>
</div><?php
	}
	
	function topicHeader($name, $rank){
?><h2 style="margin: 3px 0; display: flex"><span style="flex: 1 1 100%;">Topic: <?php echo $name; ?></span><span style="white-space: nowrap;"><?php if ($rank > 0) echo getRankName($rank) . "S ONLY"; ?></span></h2><?php
	}
?>