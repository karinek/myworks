<div id="currency_watch">
    <a href="<?=base_url('currency')?>" class="more_link">more...</a>
    <p class="menu_head">Currency Watch</p>
    <table cellpadding="1" cellspacing="1" border="1">
        <tr>
            <th width="25%">&nbsp;</th>
            <th width="15%">USD</th>
            <th width="15%">EUR</th>
            <th width="15%">CAD</th>
            <th width="15%">GBP</th>
            <th width="15%">&nbsp;</th>
        </tr>
	<?php if(!empty($currencies_base)): ?>
		<?php foreach(array('USD','EUR','CAD','GBP') as $cur): ?>
        <tr>
			<td><img src="<?=base_url('images/currencies/'.$currencies_base[$cur]->symbol.'.jpg')?>" width="16" height="11" alt="" /> <?=$currencies_base[$cur]->symbol?></td>
			<td><?=($currencies_base[$cur]->symbol == 'USD') ? '-----' : round($currencies_base[$cur]->rate*$currencies_base['USD']->inverse, 2)?></td>
			<td><?=($currencies_base[$cur]->symbol == 'EUR') ? '-----' : round($currencies_base[$cur]->rate*$currencies_base['EUR']->inverse, 2)?></td>
			<td><?=($currencies_base[$cur]->symbol == 'CAD') ? '-----' : round($currencies_base[$cur]->rate*$currencies_base['CAD']->inverse, 2)?></td>
			<td><?=($currencies_base[$cur]->symbol == 'GBP') ? '-----' : round($currencies_base[$cur]->rate*$currencies_base['GBP']->inverse, 2)?></td>
			<td>&nbsp;</td>
        </tr>
		<?php endforeach; ?>
	<?php endif; ?>
    </table>
</div>


