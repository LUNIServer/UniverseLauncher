<?php
require_once('libraries/php-markdown-lib/MarkdownInterface.php');
require_once('libraries/php-markdown-lib/Markdown.php');
use \Michelf\Markdown;

	function transform($text){
		//Transforms a mardown text to LUNI flavored HTML
		//Only compiles Markdown atm
		$my_html = Markdown::defaultTransform($text);
		return $my_html;
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