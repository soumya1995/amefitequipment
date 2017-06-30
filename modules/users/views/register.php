<?php $this->load->view('top_application');
$ref=$this->input->get_post('ref');?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading">Register</h1> 
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li class="active">Register</li>
</ul>

	<div class="regbox">
    <?php  validation_message();  ?>
    <form class="form-horizontal contact_form_cont" action="<?php echo base_url();?>users/register/" method="post">
    <input type="hidden" name="customer_type" id="customer_type" value="0" />
    <p class="fs16 text-uppercase text-center p15 bb2">Register with <br class="mob_only"><span class="blue"><?php echo $this->config->item('site_name');?></span></p>    
    <div class="p15">
    <?php /*?><p class="text-center pb12 bb2 text-uppercase fs16"><label><input name="customer_type" id="customer_type" type="radio" value="0" <?php if(set_value('customer_type') == '0'){?> checked="checked" <?php } ?>> Buyer</label> <label class="ml20"><input name="customer_type" id="customer_type" type="radio" value="1"<?php if(set_value('customer_type') == '1'){?> checked="checked" <?php } ?>> Wholesaler</label></p><?php */?>
    <p class="text-uppercase fs14 blue mb8 mt20">Login Information</p>
    <p class="input-w-l mb7">
    <input name="user_name" id="email1" class="bgW bdr p8 w95" placeholder="Email *" type="text" value="<?php echo set_value('user_name');?>">
	<small class="fs10 grey">This Email ID will be used to sign-in to <?php echo $this->config->item('site_name');?></small></p>
    
    <p class="clearfix"></p>
    <p class="input-w-l mb7"><input name="password" id="password1" placeholder="Password *" type="password" class="bgW bdr p8 w95" value="<?php echo set_value('password');?>"> <small class="fs10 grey">[Note:Password must consist of 1 special charecter and 1 number]</small></p>
    <p class="input-w-r mb7"><input name="confirm_password" id="confirm_password" placeholder="Confirm Password *" type="password" class="bgW bdr p8 w95" value="<?php echo set_value('confirm_password');?>"><?php /*?><small class="fs10 grey">[Note:Password must consist of 1 special charecter and 1 number]</small><?php */?></p>
    <p class="clearfix"></p>
    
    <p class="text-uppercase fs14 blue mb8 mt15">Personal Information</p>
    <p class="input-w-l mb7"><input name="first_name" id="first_name" placeholder="First Name *" type="text" class="bgW bdr p8 w95" value="<?php echo set_value('first_name');?>"></p>
    <p class="input-w-r mb7"><input name="last_name" id="last_name" placeholder="Last Name" type="text" class="bgW bdr p8 w95"  value="<?php echo set_value('last_name');?>"></p>
    <p class="input-w-l mb7"><input name="mobile_number" id="mobile_number" placeholder="Mobile *" type="text" class="bgW bdr p8 w95"  value="<?php echo set_value('mobile_number');?>"></p>
    <p class="input-w-r mb7"><input name="phone_number" id="phone_number" placeholder="Phone" type="text" class="bgW bdr p8 w95"  value="<?php echo set_value('phone_number');?>"></p>
    
    <p class="input-w-r mb7"><label><input name="terms_conditions" id="terms_conditions" type="checkbox" <?php if(set_value('terms_conditions')=='yes'){?> checked="checked" <?php } ?> value="yes"> I have read and agree with <a href="<?php echo base_url();?>terms-conditions" target="_blank" class="uu">Terms &amp; Conditions.</a> </label>
 </p>

<p class="input-w-r mb7"><label><input name="subscribe_newsletter" id="subscribe_newsletter" <?php if(set_value('subscribe_newsletter')=='yes'){?> checked="checked" <?php } ?> type="checkbox" value="yes"> Subscribe <strong><?php echo $this->config->item('site_name');?></strong> Newsletter</label></p>
    <p class="clearfix"></p>
    
    <p class="bb2 mt12"></p>
    
    <p class="mt20"><input name="verification_code" id="verification_code" type="text" style="width:150px;" placeholder="Word Verification *"><br class="mob_only"><img src="<?php echo site_url('captcha/normal'); ?>" class="vam p1" alt=""  id="captchaimage"/><a href="javascript:void(0);" title="Change Verification Code"  ><img src="<?php echo theme_url(); ?>images/refresh-icon.png" alt="" class="vam ml10" onclick="document.getElementById('captchaimage').src='<?php echo site_url('captcha/normal'); ?>/<?php echo uniqid(time()); ?>'+Math.random(); document.getElementById('verification_code').focus();"></a></p>
    
    <p class="mt10"><input name="submit" type="submit" class="button-style" value="Register Now"></p>
    </form>
    </div>
    
    
    <p class="cb"></p>
    </div>
    
    
</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>