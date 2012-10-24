<?php     // disabled for now ?>

<div class="forgot_password">
    <p>Not a Member Yet ? <?php echo anchor('register','Sign Up'); ?></p>
    <p class="small" style="display:none;"><?php echo anchor('login/forget_password','Forgot Your Password ?'); ?></p>
</div>



<a href="#" class="rss_block">
    <span><b>Subscribe by <i class="green">Email</i></b></span>
</a>

<?php 

if(isset($modules) && M_misc::checkModule($modules,'login')){ 
$this->load->view('modules/login');
} ?>
<?php $this->load->view('modules/top-menu'); ?>

<div class="logo">
    <a href="<?php echo base_url(); ?>"></a>
</div>