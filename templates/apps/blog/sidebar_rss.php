<?php
$words = new MOD_words();
$request = PRequest::get()->request;
$requestStr = implode('/', $request);
?>
      
      <h3><?=$words->get('Meta')?></h3>
      <ul class="linklist">
		<li><a href="rss/<?=$requestStr?>" alt="<?=$words->get('GetRSSFeed')?>" class="float_right"><img src="images/icons/feed.png"></a> <a href="rss/<?=$requestStr?>" alt="<?=$words->get('GetRSSFeed')?>"><?=$words->get('BlogEntriesRSS')?></a></li>
	<!-- NOT READY	<li><a href="rss/<?=$requestStr?>" alt="Get the RSS-Feed of this page" class="float_right"><img src="images/icons/feed.png"></a> <a href="rss/<?=$requestStr?>" alt="Get the RSS-Feed of this page">Comments RSS</a></li> -->
      </ul>
