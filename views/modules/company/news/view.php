<div style="padding:20px;">
	<h3 style="font-size:150%;font-weight:bold;margin-bottom:20px;">Feed Details</h3>
	<p>
		<span style="font-weight:bold;">Title</span><br /><?=isset($feed['title'])?$feed['title']:''?>
	</p>
	<br />
	<p>
		<span style="font-weight:bold;">Link</span><br /><a href="<?=isset($feed['link'])?$feed['link']:'#'?>"><?=isset($feed['link'])?$feed['link']:'-'?></a>
	</p>
	<br />
	<p>
		<span style="font-weight:bold;">Content</span><br /><?=isset($feed['content'])?$feed['content']:''?>
	</p>
</div>
