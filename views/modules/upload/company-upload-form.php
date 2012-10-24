<script type="text/javascript" src="<?=base_url()?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/ajaxupload.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/jquery.jcrop.min.js"></script> 
<?=link_tag('css/jquery.jcrop.css')?>
<?=link_tag('css/reset.css')?>
<?=link_tag('css/style.css')?>
<style>
.content{
	margin: 0 auto;
	padding:15px;
}
.left{
	float: left;
	height: 135px;
	margin-bottom: 10px;
	margin-right: 10px;
	width: 685px;
}
.right{
	background-color: black;
	height: 575px;
	/*margin-left: 165px;*/
	width: 685px;
}
.title{
	padding:10px 0;
	font-size:125%;
	font-weight:bold;
}
img#preview{
	width: 260px;
	height: 100px;
}
.preview_container{
	position: relative;
	width: 260px;
	height: 100px;
	overflow: hidden;
	margin-bottom: 10px;
	float:left;
}
div#preview_container{
	width: 260px;
	height: 100px;
	display: block;
	overflow: hidden;
}
.button{
	background: url("<?=base_url('images/suppliers.png')?>") repeat-x scroll left top #A7C84C;
	margin-left: 10px;
	margin-bottom: 10px;
	width: 130px;
    border: 1px solid #A2BA66;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    color: white;
    cursor: pointer;
    display: block;
    font-size: 16px;
    font-weight: bold;
    height: 35px;
    line-height: 35px;
    padding: 0;
    text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    text-align: center;
	float:left;
	overflow:hidden;
}
.button-container{
	position:absolute;
	right:0;
	top:112px;
	width:436px;
	height:45px;
}
input#file_input{
	height: 35px;
	left: 0;
	opacity: 0;
	position: absolute;
	top: 0;
	width: 130px;
	z-index: 1;
}

</style>
<div class="content">
	<div class="left">
		<div class="title">Upload Image</div>
		<input id="upload_image" name="params[image]" type="hidden"/>
		<div class="preview_container">
			<div id="preview_container" action="<?=base_url('upload/priviewImage?module='.(isset($module['name'])?$module['name']:'default'))?>">
				<img id="preview" src="<?=base_url()?>images/<?=isset($staff['image'])? 'user_images/'.$staff['image'] : 'company.png'?>"/>
			</div>
		</div>
		<div class="button-container">
			<div class="button" style="position:relative;width:128px;height:33px;">
				Upload Image
				<input name="contactimage" type="file" id="file_input" />
			</div><div style="clear:right;"></div>
			<form id="cropattrform" action="<?=base_url('upload/processImage')?>" method="post" onSubmit="return checkCoords();" class="crop_control">
				<input type="hidden" name="module[name]" value="<?=isset($module['name'])?$module['name']:'default'?>" />
				<input type="hidden" name="module[id]" value="<?=isset($module['id'])?$module['id']:0?>" />
				<input type="hidden" id="x" name="params[x]" />
				<input type="hidden" id="y" name="params[y]" />
				<input type="hidden" id="w" name="params[w]" />
				<input type="hidden" id="h" name="params[h]" />
				<input type="hidden" id="tempfile" name="tempfile" />
				<input type="hidden" id="task" name="task" />
				<input type="submit" id="_crop_bttn" value="Apply" class="button" disabled="disabled">
				<input type="button" id="_crop_cancel_bttn" value="Cancel" class="button">
			</form>
		</div>
	</div>
	<div class="clear"></div>
	<div class="right">
		<div id="image_container"> </div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var thumb = $('#preview');	
		$('#_crop_cancel_bttn').click(function(){
			var $this = $('form#cropattrform');
			$('#task').val('cancel');
			
			$request = $.post($this.attr('action'),{task:'cancel'},function(r){
				top.Shadowbox.close();
			},'json');
			$request.error(function(){
				console.log('error while uploading image');
				top.Shadowbox.close();
			});
		});
		$('form#cropattrform').submit(function(){
			var data = {};
			var $this = $(this);
			$this.find('input, select, textarea').each(function(){
				var $el = $(this);
				data[$el.attr('name')] = $el.val();
			});
			$request = $.post($this.attr('action'),data,function(r){
				if(r.status){
					if(r.callback!='') eval('top.'+r.callback+'('+JSON.stringify(r)+')');
					top.Shadowbox.close();
				}else{
					alert('error');
				}
			},'json');
			$request.error(function(){
				alert('error while uploading image');
			});
			return false;
		});
		new AjaxUpload('file_input', {
			action: $('#preview_container').attr('action'),
			name: 'contactimage',
			onSubmit: function(file, extension) {
				thumb.css({
					'width': 24,
					'height': 24,
					position:'absolute',
					left: ($imgpos.rasio_width-24) / 2,
					top: ($imgpos.rasio_height-24) / 2
				});
				thumb.attr('src', "<?php echo base_url(); ?>images/" + "loading.gif");
				$('form input:submit').attr('disabled',true);
			},
			onComplete: function(file, response) {
				$('form input:submit').attr('disabled',false);
				var r = JSON.parse(response);
				if(r.status){
					$('#image_container').css({
						'margin-top':(575-r.height)/2,
						'margin-left':(685-r.width)/2,
						'float': 'left'
					});
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
							aspectRatio: $imgpos.rasio_width / $imgpos.rasio_height,
							onSelect: updateCoords,
							setSelect: [ 0, 0, $imgpos.rasio_width, $imgpos.rasio_height ]
						});
				
						$("#preview").remove();
						
						var _imgprev = $(document.createElement('img')).attr('id','preview').attr('src', img_path + "/" + r.file);
						$('#preview_container').append(_imgprev);
					}).attr('src', img_path + "/" + r.file);
					$('#tempfile').val(r.file);
				}	
				else alert('error');
			}
		});
	});
	function updateCoords(c){
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#w').val(c.w);
		$('#h').val(c.h);
	};
	
	function checkCoords(){
		if (parseInt($('#w').val())){
			return true;
		}	
		$('#x').val(0);
		$('#y').val(0);
		$('#w').val($imgpos.rasio_width);
		$('#h').val($imgpos.rasio_height);
		return true;
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
		rasio_width: 260,
		rasio_height: 100,
		width	: 260,
		height	: 100
	};
</script> 