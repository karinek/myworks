<script type="text/javascript" src="<?php echo base_url("js/jquery-1.7.2.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/jquery-ui-1.8.20.custom.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/validation/jquery.validate.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/admin/category.js"); ?>"></script>
<style>
.error{color:#f00;}
table tr{border: 1px solid #fbfbfb;}
table td{vertical-align: top;}
</style>
<?php echo form_open('attribute/update',array('name'=>'catAttribute'),$hidden); ?>
	<br />
	<table colspan="0" cellpadding="0" border="0">
		<tr>
			<td></td>
			<td><input type="button" value="Cancel" onclick="window.location='<?php echo base_url('attribute/display/'.$category->parent_id); ?>'"><input type="submit" value="Save"></td>
		</tr>
		<tr>
			<td>Name</td>
			<td><input type="text" name="category_name" value="<?php echo $category->category_name; ?>"></td>
		</tr>
		<tr>
			<td>Attribute(s)</td>
			<td>
<?php if($isLeaf): ?>
				<div class="panel">
					<input type="button" value="Add New" onclick="category.addAttribute()">
				</div>
				<table style="display:none;">
					<tr id="custom-attribute-tmpl" >
						<td><input type="text" name="attr_name" class="attr_name required"><input type="hidden" name="attr_new" value="1"></td>
						<td>
							<select name="attr_type" class="attr_type">
								<option value="label">label</option>
								<option value="textbox">textbox</option>
								<option value="textarea">textarea</option>
								<option value="checkbox">checkbox</option>
								<option value="optionbox">optionbox</option>
								<option value="selectbox">selectbox</option>
								<option value="country">country</option>
							</select>
						</td>
						<td><textarea name="attr_value" class="attr_value"></textarea></td>
						<td><input type="checkbox" name="attr_required" value="1" class="attr_required"></td>
						<td><input type="button" onclick="category.removeAttribute()" value="remove" class="remove_button"><span class="order-handle">drag</span></td>
					</tr>
				</table>
				<table id="custom-attribute">
					<thead>
						<th>Attr. Name</th>
						<th>Attr. Type</th>
						<th>Attr. Value</th>
						<th>Attr. Is Required</th>
						<th></th>
					</thead>
					<tbody>
					<?php
					echo renderAttribute($attributes);
					?>
				</tbody>
				</table>
<?php else: ?>
				<span>Parent Category can't have an attribute.</span>
<?php endif; ?>
			</td>
		</tr>	
	</table>
<?php echo form_close() ?>
<?php
	function renderAttribute($items){
		if(!count($items) || !is_array($items)) return false;
		foreach($items as $key => $item):
?>
					<tr id="tr_<?php echo $item->attr_id ?>">
						<td>
						<?php
							echo form_input(array(
								'name' => 'params[attribute]['.$item->attr_id.'][attr_name]',
								'class' => 'attr_name required',
								'value' => $item->attr_name
							));
							echo form_hidden('params[attribute]['.$item->attr_id.'][attr_new]',0);
						?>
						<td>
						<?php
							echo form_dropdown(
								'params[attribute]['.$item->attr_id.'][attr_type]',
								array(
									'label'=>'label',
									'textbox'=>'textbox',
									'textarea'=>'textarea',
									'checkbox'=>'checkbox',
									'optionbox'=>'optionbox',
									'selectbox'=>'selectbox',
									'country'=>'country'
								),
								$item->attr_type,
								'class="attr_type"'
							);
						?>
						</td>
						<td>
						<?php
							echo form_textarea(array(
								'name' => 'params[attribute]['.$item->attr_id.'][attr_value]',
								'class' => 'attr_value',
								'value' => str_replace("|","\n",stripslashes($item->attr_value)),
								'cols' => 15,
								'rows' => 5
							));
						?>
						</td>
						<td>
						<?php
							echo form_checkbox(array(
								'name' => 'params[attribute]['.$item->attr_id.'][attr_required]',
								'class' => 'attr_required',
								'value' => 1,
								'checked' => $item->attr_required == 1 ? true : false
							));
						?>
						</td>
						<td>
						<?php
						/*
							echo form_button(array(
								'onclick' => 'category.removeAttribute('.$item->attr_id.')',
								'content' => 'remove',
								'name' => 'remove'
							));
						*/
						?>
						<span class="order-handle">drag</span>
						</td>
					</tr>
<?php
		endforeach;
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
?>