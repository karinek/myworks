<h3 class="page_links"><a href="#">Home</a> &gt; <a href="#">Currency Watch</a></h3>
<div class="currency_watch_page_wrapper">
	<div class="currency_watch_page">
	<?php $i=0; ?>
	<?php foreach($currencies as $cur): ?>
		<?php if ($i%10 == 0): ?>
		<div class="currency_watch_page_left">
			<table cellpadding="1" cellspacing="1" border="1" width="100%">
				<tr>
					<th width="25%">&nbsp;</th>
					<th width="15%">USD</th>
					<th width="15%">EUR</th>
					<th width="15%">CAD</th>
					<th width="15%">GBP</th>
					<th width="15%">&nbsp;</th>
				</tr>
		 <?php endif; ?>
			 <tr>
				<td><img src="<?=base_url('images/currencies/'.$cur->symbol.'.jpg')?>" width="16" height="11" alt="" /> <?=$cur->symbol?></td>
				<td><?=($cur->symbol == 'USD') ? '-----' : round($cur->rate*$currencies_base['USD']->inverse, 2)?></td>
				<td><?=($cur->symbol == 'EUR') ? '-----' : round($cur->rate*$currencies_base['EUR']->inverse, 2)?></td>
				<td><?=($cur->symbol == 'CAD') ? '-----' : round($cur->rate*$currencies_base['CAD']->inverse, 2)?></td>
				<td><?=($cur->symbol == 'GBP') ? '-----' : round($cur->rate*$currencies_base['GBP']->inverse, 2)?></td>
				<td>&nbsp;</td>
			</tr>
		<?php $i++; ?>
		<?php if ($i%10 == 0): ?>
			</table>
		</div>
		<?php endif; ?>
	<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>