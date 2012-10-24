<div class="topic-info">
	<div class="topic-state">
			Add to watch list
			<a href="javascript:doRating(1);" class="topic-dislike sprite" title="Not Worth Reading"><?=intval($topic->dislike)?></a>
			<a href="javascript:doRating(5);" class="topic-like sprite" title="Worth Reading"><?=intval($topic->like)?></a>
	</div>
	<div class="topic-name"> <span><?=strip_tags($topic->subject)?></span> </div>
</div>
