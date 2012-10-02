<?php 

header('Content-Type: application/rss+xml'); 
echo '<?xml version="1.0" encoding="UTF-8"?>';

include_once '../library/bootstrap.php';
include_once LOGIC . 'properties.php';
include_once LOGIC . 'rss.php';
?>

<rss version="2.0">
	<channel>
		<title><?=$rss['channel']['title']?></title>
		<link><?=$rss['channel']['link']?></link>
		<description><?=$rss['channel']['description']?></description>
		<language><?=$rss['channel']['language']?></language>
		<pubDate><?=$rss['channel']['pubDate']?></pubDate>
		<lastBuildDate><?=$rss['channel']['lastBuildDate']?></lastBuildDate>
		<?php foreach ( $rss['channel']['item'] as $item ) { ?>
		<item>
			<title><?=$item['title']?></title>
			<link><?=$item['link']?></link>
			<description><?=$item['description']?></description>
			<pubDate><?=$item['pubDate']?></pubDate>
		</item>
		<?php } ?>
	</channel>
</rss>