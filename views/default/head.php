<?= link_tag('css/reset.css') ?>
<?= link_tag('css/style.css') ?>
<?= link_tag('css/nivo.css') ?>
<?= link_tag('css/skin.css') ?>
<?= link_tag('css/jquery.selectbox.css') ?>   
<?= link_tag('css/lightbox.css') ?>
<?= link_tag('css/colorbox.css') ?>
<?= link_tag('css/jquery.jscrollpane.css') ?>
<?= link_tag('css/jquery.autocomplete.css') ?>
<?= link_tag('js/shadowbox/shadowbox.css') ?>
<?= link_tag('css/sliderkit-core.css') ?>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.colorbox.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.8.18.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/myscript.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/ui.checkbox.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.autocomplete.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.selectbox-0.1.3.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/lightbox.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/search.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.reveal.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.textreflection.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/shadowbox/shadowbox.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/app.js"></script>
<script type="text/javascript" src="<?= base_url() ?>js/jquery.sliderkit.1.9.2.pack.js"></script>
<script type="text/javascript">
    if(typeof app == 'undefined') var app = {};
    app.base_url = function(uri){return '<?= base_url() ?>'+(uri!=null?uri:'');};
    var base_url = function(uri){return '<?= base_url() ?>'+(uri!=null?uri:'');};

    $(document).ready(function() {
        // hack for input box for changing the font color
        $('input').bind('click change',function(){
            var $this = $(this);
            $this.data('ori_setting',{
                value: $this.val(), 
                style: {
                    'color':$this.css('color'),
                    'font-style':$this.css('font-style'),
                    'font-weight':$this.css('font-weight')
                }
            });
            $this.css({'color':'#44463A','font-style':'normal','font-weight':'bold'});
            $this.one('blur',function(){
                var $data = $this.data('ori_setting');
                if($this.val()==$data.value){
                    $this.css($data.style);
                }
            })
        })

        $('.rss_block').click(function(e) { // Button which will activate our modal
            $('#modal').reveal({ // The item which will be opened with reveal
                animation: 'fade',                   // fade, fadeAndPop, none
                animationspeed: 600,                       // how fast animtions are
                closeonbackgroundclick: true,              // if you click background will modal close?
                dismissmodalclass: 'closer'    // the class of a button or element that will close an open modal
            });
            return false;
        });
        $('#popup').click(function(){
            $('#contentBox').hide();
            $('#popup').hide();
        });
                
        $('.editIcon').click(function(){
            $('#popup').show();
            $('#contentBox').show();
            $.get($(this).attr('data-href'), function(data) {
                $('#contentBox').html(data);
            });
        });

        $('.addIcon').click(function(){
            $('#popup').show();
            $('#contentBox').show();
            $.get($(this).attr('data-href'), function(data) {
                $('#contentBox').html(data);
            });
        });
        $('.news_scrollbar ul').jScrollPane({showArrows: true});
        $('.terms_conditions').jScrollPane({showArrows: true});
    });
</script>
<script type="text/javascript">
    $(function(){
        $('.products_head_form input').checkBox();
        $('.registration_checkbox_list input').checkBox();
        $('#advanced_search_block input').checkBox();
        $('.select_membership_types_item input').checkBox();
        $('.membership_steps_right input').checkBox();
    });
</script>
<script type="text/javascript">
    $(function () {
        $(".email_contact").colorbox({height:'auto'});
           
        jQuery("#country_id1").selectbox();
        jQuery("#country_id2").selectbox();
        jQuery("#country_id3").selectbox();
        jQuery("#country_id4").selectbox();
        jQuery("#country_id5").selectbox();
        jQuery("#country_id6").selectbox();
        jQuery("#business_type").selectbox();
        jQuery("#time_period1").selectbox();
            
        jQuery("#category_1").selectbox();  
        jQuery("#category_2").selectbox();  
        jQuery("#category_3").selectbox();
            
        jQuery("#select2").selectbox();
        jQuery("#select3").selectbox();
        jQuery("#product_order").selectbox();
        jQuery("#month").selectbox();
        jQuery("#year").selectbox();
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function() {
   
    
        jQuery('#mycarousel1').jcarousel({
            wrap: 'circular',
            scroll: 1,
            auto:3
        });
        jQuery('#mycarousel2').jcarousel({
            wrap: 'circular',
            scroll: 1,
            auto:4
        });
        jQuery('#mycarousel3').jcarousel({
            wrap: 'circular',
            scroll: 1,
            auto:5
        });
    
        jQuery('#latest_offers').jcarousel({
            wrap: 'circular',     
            scroll: 1,
            auto:5000,
            vertical: true
        });
        $(".newslider-vertical").sliderkit({
            shownavitems:3,
            verticalnav:true,
            navitemshover:true,
            circular:true
        });
        jQuery('.like_mask').click(function(){
            var $this =  $(this);
            $.get("<?= base_url() ?>welcome/like/"+$(this).attr('id'), {}, function(data){
                $this.next().html(data);
            });
     
        });
    });
</script>
<script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider({
            pauseTime:5000
        });
    });
</script>
<script type="text/javascript">
    $(window).load(function(){
        //Add more button for categories
        $('li.categories .sbOptions').append('<li class="more">More...</li>');
        $('li.categories .sbOptions li').each(function(index, element) {
            if($(this).index() > 20){$(this).addClass('hide_option')};
            $('li.categories .sbOptions li.hide_option').hide();
            $('li.categories .sbOptions li.more').show();
        });
        $('li.categories .sbOptions li.more').click(function(){
            $('li.categories .sbOptions li.hide_option').slideDown(500);
            $('li.categories .sbOptions li.more').hide();
        });
 
        $('li.categories .sbSelector').click(function(){
            $('li.categories .sbOptions li.hide_option').hide();
            $('li.categories .sbOptions li.more').show();
        });
        //END
  
        //Add more button for categories
        //$('li.region .sbOptions').append('<li class="more">More...</li>');
        /*$('li.region .sbOptions li').each(function(index, element) {
        if($(this).index() > 20){$(this).addClass('hide_option')};
  $('li.region .sbOptions li.hide_option').hide();
  $('li.region .sbOptions li.more').show();
  });*/
        /*$('li.region .sbOptions li.more').click(function(){
  $('li.region .sbOptions li.hide_option').slideDown(500);
  $('li.region .sbOptions li.more').hide();
  });*/
 
        $('li.region .sbSelector').click(function(){
            $('li.region .sbOptions li.hide_option').hide();
            $('li.region .sbOptions li.more').show();
        });
        //END
    });
</script>