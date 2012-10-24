<?php $params = (isset($additional) && $additional != '')?$additional.'&':''; ?>
<ul class="my_contacts_pagination">
    <li><a href="<?php echo '?'.$params.'page='.$pagination['page']; ?>">Last Page</a></li>
    <li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?'.$params.'page='.($pagination['cur']+1).'"></a>' ?></li>
    <li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?'.$params.'page='.($pagination['cur']-1).'"></a>' ?></li>
    <li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
</ul>

<h3><?=($type != '')?$this->type_headers[$type]:"Frequently asked questions?";?></h3>
<p><?=($type != '')?"Step by Step process:":"View The latest Questions";?>:</p>

<?php if(count($faqs)): ?>
    <?php foreach($faqs as $faq): ?>
        <h4><a href="<?=base_url('faq/view/'.$faq->id);?>"><?php echo $faq->question; ?></a></h4>
        <p><?php echo $faq->answer; ?></p>
    <?php endforeach; ?>
<?php else: ?>
        <p>No results found.</p>
<?php endif; ?>        
        
<ul class="my_contacts_pagination">
    <li><a href="<?php echo '/?'.$params.'page='.$pagination['page']; ?>">Last Page</a></li>
    <li class="next <?=$pagination['cur'] >= $pagination['page'] ?'disable':''?>"><?= $pagination['cur'] >= $pagination['page'] ? '<a href="#"></a>' : '<a href="?'.$params.'page='.($pagination['cur']+1).'"></a>' ?></li>
    <li class="prev <?=$pagination['cur'] <=1?'disable':''?>"><?= $pagination['cur'] <= 1 ? '<a href="#"></a>' : '<a href="?'.$params.'page='.($pagination['cur']-1).'"></a>' ?></li>
    <li>Page <span><?=$pagination['cur']?></span> / <?=$pagination['page']?></li>
</ul>

