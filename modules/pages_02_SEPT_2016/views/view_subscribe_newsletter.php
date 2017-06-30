<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome to :: AME Fitness Equipment</title>
<link href="<?php echo base_url(); ?>assets/developers/css/proj.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico">
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
<?php echo error_message();
 echo form_open('pages/newsletter');?>
 <input name="subscribe_me" type="hidden" id="saction" value="" />
 <p class="heading">Newsletter</p>
  <p class="mt10"><input name="subscriber_name" id="subscriber_name" type="text" class="txtbox w95" placeholder="Your Name" value="<?php echo set_value('subscriber_name');?>"><?php echo form_error('subscriber_name');?></p>
  <p class="mt5"><input name="subscriber_email" id="subscriber_email" type="text" class="txtbox w95" placeholder="Your Email ID" value="<?php echo set_value('subscriber_email');?>" ><?php echo form_error('subscriber_email');?></p>
  <p class="mt10">
  <label><input name="subscribe" id="subscribe" type="radio" value="Subscribe" onclick="document.getElementById('saction').value='Y'"> Subscribe</label> 		  <label class="ml20"><input name="unsubscribe" id="unsubscribe" type="radio" value="Unsubscribe" onclick="document.getElementById('saction').value='N'"> Unsubscribe</label></p>
  <p class="mt10"><input name="submit" type="submit"  value="Submit" class="button-style" /></p>
  <?php echo form_close();?>
</div>
</body>
</html>