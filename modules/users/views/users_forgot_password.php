<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome to :: AME Fitness Equipment</title>
<link href="<?php echo base_url(); ?>assets/developers/css/proj.css" rel="stylesheet" type="text/css" />
<link href="<?php echo theme_url();?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo theme_url();?>css/ame-preet.css" type="text/css" rel="stylesheet">
<style type="text/css" media="screen">
<!--
@import url("<?php echo resource_url();?>fancybox/jquery.fancybox.css");
-->
</style>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
</head>
<body>
  <h1 class="heading">Forgot Password?</h1>
   <?php
	echo error_message();	    	  
	validation_message();
?>
  <p class="clearfix"></p>
  <?php
 echo form_open('users/forgotten_password/');?>
 <input type="hidden" name="forgotme" value="yes" />
  <p class="mt10"><label for="email">Your Email ID </label></p>
  <p><input name="email" id="emailid" type="text" placeholder="Email Id *" class="txtbox w95"/><?php echo form_error('email');?></p>
  <p class="mt10"><input name="verification_code" id="verification_code" type="text" style="width:170px;" class="txtbox mb5" placeholder="Enter This Code ">
	<img src="<?php echo site_url('captcha/normal'); ?>" class="vam" alt=""  id="captchaimage"/> &nbsp; 
  <a href="javascript:void(0);" title="Change Verification Code"  ><img src="<?php echo theme_url(); ?>images/refresh-icon.png"  alt="Refresh"  onclick="document.getElementById('captchaimage').src='<?php echo site_url('captcha/normal'); ?>/<?php echo uniqid(time()); ?>'+Math.random(); document.getElementById('verification_code').focus();" class="vam mt8"></a><?php echo form_error('verification_code');?>
</p>        
  <p class="mt10"><input name="submit" type="submit"  value="Send" class="button-style" /></p>
  <?php echo form_close();?>
</body>
</html>
