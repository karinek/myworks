<?php if(count($groups) && is_array($groups)): ?>
<div><input type="button" value="Add"><input type="button" value="Save"></div>
<div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<th width="513" scope="col">Group Name</th>
			<th width="" scope="col">Description</th>
			<th width="" scope="col">Action</th>
		<thead>
		<tbody>
	<?php foreach($groups as $group): ?>
			<tr>
				<td><input type="text" name="params[groups][]" value="<?=$group->name?>"></td>
				<td><?=$group->desc?></td>
				<td><input type="button" value="Manage Category"></td>
			</tr>
	<?php endforeach; ?>	
		</tbody>
	</table>
</div>
<div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<thead>
			<th width="513" scope="col"><?=$group->name?></th>
			<th width="" scope="col">Topics</th>
		<thead>
		<tbody>
	<?php $categories = $this->m_forum->get('category',array('group_id'=>$group->id)); ?>
	<?php if(count($categories) && is_array($categories)): ?>
		<?php foreach($categories as $category): ?>
			<?php $topic = $this->m_forum->get('topic',array('id'=>$category->last_topic_id)); ?>
			<tr class="normal-tr">
				<td class="left">
					<h4><?=anchor('forum/category/'.$category->id,'<strong>'.$category->name.'</strong>')?></h4>
					<p><?=stripslashes($category->desc)?></p>
					<p> <strong>Moderator:</strong> <a href="/resources_profile/chuangda.htm">Elecpack</a> ,<a href="/resources_profile/grigointernational.htm">grigo</a> </p></td>
				<td class="center">
				<?php if($topic): ?>
					<?php $t_user = $this->m_forum->get('user',array('user_id'=>$topic[0]->user_id)); ?>
					<?=anchor('forum/topic/'.$topic[0]->id,'<strong>'.$topic[0]->subject.'</strong>')?><br>
					by: <?=anchor('forum/profile/'.$t_user[0]->username,'<span>'.$t_user[0]->username.'</span>')?><br>
					<?=$this->m_misc->formatDate('d M Y H:i',intval($category->cdate))?></td>
				<?php else: ?>
					No topic
				<?php endif; ?>
				<td class="right">
					<span class="topics"><?=$this->m_misc->formatNumber(intval($category->topics))?></span>
				</td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>
