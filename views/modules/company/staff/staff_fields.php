<?=link_tag('css/reset.css')?>
<?=link_tag('css/style.css')?>
<?=link_tag('css/jquery.selectbox.css')?>   
<script type="text/javascript" src="<?=base_url()?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery-ui-1.8.18.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.jcarousel.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
<style>

</style>
<div class="content">
    <?=form_open_multipart('company/staff/save','id="aaa"',array('params[company_id]'=>isset($staff['company_id'])?$staff['company_id']:0,'params[id]'=>isset($staff['id'])? $staff['id']: 0))?>
    <div>
		<h3>Staff Member Details:</h3>
		<p><span style="margin-right:100px;">First Name</span>Last Name</p>
		<input type="text" name="params[firstname]" class="required inputbox" value="<?=isset($staff['firstname'])?$staff['firstname']:''?>" alt="First Name" style="width:155px; margin-right:5px;" />
		<input type="text" name="params[lastname]" class="required inputbox" value="<?=isset($staff['lastname'])?$staff['lastname']:''?>" alt="Last Name" style="width:160px;" />
		
		<p><span style="margin-right:46px;">Tel</span></p>
		<input type="text" name="params[phone]" value="<?=isset($staff['phone'])?$staff['phone']:''?>" alt="Phone Number" class="inputbox"/>
		
		<p>Mob</p>
		<input type="text" name="params[mobile]" value="<?=isset($staff['mobile'])?$staff['mobile']:''?>" alt="Mobile Number" class="inputbox" />
		
		<p>Email:</p>
		<input type="text" name="params[email]" class="required email inputbox" value="<?=isset($staff['email'])?$staff['email']:''?>" alt="Email" />
		
		<p>Position:</p>
		<input type="text" name="params[position]" class="required inputbox" value="<?=isset($staff['position'])?$staff['position']:''?>" alt="Position" />
		<div style="display:none;">
			<input id="upload_image" name="params[image]" type="hidden"/>
			<div class="preview_container">
				<div id="preview_container">
					<img id="preview" src="<?=base_url()?>images/user_images/<?=isset($staff['image'])? $staff['image'] : 'no-photo.jpg'?>"/>
				</div>
			</div>
	
			<div id="mask1"  action="<?=base_url('upload/priviewImage')?>" style="width: 140px;cursor: pointer" >
				<div class="mask_button1" style="width: 138px;cursor: pointer">Upload Image</div>
				<input name="contactimage" type="file" id="file_input" />
				<input name="contactimage" type="file"  style="width: 140px;cursor: pointer" id="fileInput1" />
				<input id="upload_image_folder" type="hidden" value="<?php echo site_url('images/user_images/temp/'); ?>"/>
			</div>
        </div>   
		<input type="submit" class="submit_staff" value="SAVE" />
	</div>
	<?=form_close()?>
	<script>
	$(document).ready(function(e) {
		$('.close').click(function(){
			$('#contentBox').hide();
			$('#popup').hide(); 
		});

		$('form#aaa').validate();

		$('form#cropattrform').submit(function(){
			if (parseInt($('#w').val())){
				return true;
			}	
			$('#x').val(0);
			$('#y').val(0);
			$('#w').val(150);
			$('#h').val(150);
			return true;
		});
		
		var thumb = $('#thumb');	
		
		new AjaxUpload('fileInput1', {
			action: $('#mask1').attr('action'),
			name: 'contactimage',
			onSubmit: function(file, extension) {
				thumb.attr('width', "30px");
				thumb.attr('height', "30px");
				thumb.attr('src', "<?php echo base_url(); ?>images/" + "loading.gif");
				$('form input:submit').attr('disabled',true);
			},
			onComplete: function(file, response) {
				var r = JSON.parse(response);
				if(r.status){
					console.log(JSON.stringify(r));
					var img_path = r.path;
					var img = new Image();
					$(img).load(function () {
						$imgpos.width  = r.width;
						$imgpos.height = r.height;
						$("#cropbox").remove();
						$(".jcrop-holder").remove();
						$(this).attr('id','cropbox');
						$(this).hide();
						$('#image_container').append(this);
						
						$(this).fadeIn().Jcrop({
							onChange: showPreview,
							onSelect: showPreview,
							aspectRatio: 1,
							onSelect: updateCoords,
							setSelect: [ 0, 0, 150, 150 ]
						});
				
						$("#preview").remove();
						
						var _imgprev = $(document.createElement('img')).attr('id','preview').attr('src', img_path + "/" + r.file);
						$('#preview_container').append(_imgprev);
				
						if(!$('#_crop_bttn').length){		
							var _crop_bttn = $(document.createElement('input')).attr('id','_crop_bttn').attr('type','submit').val('save');
							var _crop_cancel_bttn = $(document.createElement('input')).attr('id','_crop_cancel_bttn').attr('type','submit').val('cancel');
							_crop_cancel_bttn.click(function(){$('#cropattrform input.jq_step').val('cancel');});	
							_crop_bttn.click(function(){$('#cropattrform input.jq_step').val('process');});	
							$('#cropattrform').append(_crop_bttn).append(_crop_cancel_bttn);
						}
					}).attr('src', img_path + "/" + r.file);
					$('#tempfile').val(r.file);
				}	
				else alert('error');

				$('form input:submit').attr('disabled',false);
			}
		});
	});
	function updateCoords(c){
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#w').val(c.w);
		$('#h').val(c.h);
	};
	
	function showPreview(coords){
		if (parseInt(coords.w) > 0){
			var rx = $imgpos.rasio_width / coords.w;
			var ry = $imgpos.rasio_height / coords.h;
			$('#preview').css({
				width: Math.round(rx * $imgpos.width) + 'px',
				height: Math.round(ry * $imgpos.height) + 'px',
				marginLeft: '-' + Math.round(rx * coords.x) + 'px',
				marginTop: '-' + Math.round(ry * coords.y) + 'px'
			});
		}
	};
	
	$imgpos = {
		rasio_width: 150,
		rasio_height: 150,
		width	: 150,
		height	: 150
	};

	</script>
</div>