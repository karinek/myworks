<div style="padding-bottom: 20px;">
<h3 class="page_links"><a href="<?=base_url()?>">Home</a> &gt;
<a href="<?=base_url('myoffice')?>">My Account </a> &gt;
<?=$selectedPage?></h3>
</div>
<ul id="office_tabs">
	<li class="my_office<?=$selectedPage=='My Office'?' active':''?>"><a href="<?=base_url('myoffice')?>">My Office</a></li>
	<li class="contacts_messages<?=$selectedPage=='My Messages'?' active':''?>"><a href="<?=base_url('message/inbox')?>">My Messages</a></li>
	<li class="company_page<?=$selectedPage=='My Company'?' active':''?>"><a href="<?=base_url('company')?>">My Company</a></li>
	<li class="buying<?=$selectedPage=='My Proflie'?' active':''?>"><a href="<?=base_url('user/editprofile')?>">My Proflie</a></li>
	<li class="selling<?=$selectedPage=='Buying'?' active':''?>"><a href="<?=base_url('request/buy')?>">Buying</a></li>
	<li class="b2b<?=$selectedPage=='Selling'?' active':''?>"><a href="<?=base_url('product')?>">Selling</a></li>
	<li class="my_contacts<?=$selectedPage=='Watchlist'?' active':''?>"><a href="<?=base_url('user/watchlist')?>/">Watchlist</a></li>
</ul>
