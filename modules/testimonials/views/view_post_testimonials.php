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
<?php
echo error_message();
echo  form_open('');?>
  <h1 class="heading">Post Your Testimonial</h1>
  <p class="mt5">
  <input name="poster_name" id="person_name" type="text" class="txtbox w100" placeholder="Your Name * " value="<?php echo set_value('poster_name');?>"><?php echo form_error('poster_name');?>
  </p>
  <p class="mt5"><input name="email" id="email" autocomplete="off" type="text" class="txtbox w100" placeholder="Your Email ID * " value="<?php echo set_value('email');?>"><?php echo form_error('email');?></p>
  <p class="mt5">
  <textarea name="testimonial_description" id="description" rows="4" class="txtbox w100" placeholder="Comments * "><?php echo set_value('testimonial_description');?></textarea><?php echo form_error('testimonial_description');?>
  </p>
<p class="mt10"><input name="verification_code" id="verification _code" type="text" style="width:150px;" placeholder="Word Verification *" value=""><br class="mob_only"><img src="<?php echo site_url('captcha/normal');?>" class="vam p1" alt="" id="captchaimage" /> <a href="javascript:void(0);" title="Change Verification Code"><img src="<?php echo theme_url();?>images/refresh-icon.png"  alt="Refresh"  onclick="document.getElementById('captchaimage').src='<?php echo site_url('captcha/normal');?>/<?php echo uniqid(time());?>'+Math.random(); document.getElementById('verification_code').focus();" class="vam ml10"></a>
              <p class="grey pt5 fs11">Type the characters shown above.</p><?php echo form_error('verification_code');?></p>        
  <p class="mt10"><input name="submit" type="submit"  value="Post" class="button-style" /></p>
<?php echo form_close();?> 
</body>
</html>
