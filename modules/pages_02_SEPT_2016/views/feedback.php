<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<link rel="shortcut icon" href="favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PI Ecommerce</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo theme_url(); ?>css/sl.css">
<link rel="stylesheet" href="<?php echo theme_url(); ?>css/conditional_sl.css">
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css" media="screen">
<!--
-->
</style>
</head>
<body style="padding:0">
<div class="p10 pt5 pb5">
  <h1>Send Enquiry</h1>
  <?php echo error_message();
    echo form_open('pages/feedback');?>
  <p class="mt7">
    <input name="first_name" id="first_name" type="text" placeholder="Name *" class="p8 w100 radius-3" value="<?php echo set_value('first_name');?>" /><?php echo form_error('first_name');?>
  </p>
  <p class="mt7">
    <input name="email" id="email" type="text" placeholder="Your Email ID *" class="p8 w100 radius-3" value="<?php echo set_value('email');?>"><?php echo form_error('email');?>
  </p>
  <p class="mt7">
  <textarea name="message" id="message" class="p8 w100 radius-3" id="friend_name" placeholder="Comment *"><?php echo set_value('message');?></textarea><?php echo form_error('message');?>
  </p>
  <p class="mt7 fl">
    <input name="verification_code" id="verification _code" type="text" class="p8 radius-3" style="width:120px"  placeholder="Word Verification *" value="">
  </p>
  <p class="mt12 fl ml10"><img src="<?php echo site_url('captcha/normal');?>" class="vam" alt="" id="captchaimage" /> <a href="javascript:void(0);" title="Change Verification Code"><img src="<?php echo theme_url();?>images/refresh-icon.png"  alt="Refresh"  onclick="document.getElementById('captchaimage').src='<?php echo site_url('captcha/normal');?>/<?php echo uniqid(time());?>'+Math.random(); document.getElementById('verification_code').focus();" class="vam radius-5 ml5"></a><?php echo form_error('verification_code');?></p>
  <div class="cb"></div>
  <p class="mt10">
    <input name="submit" type="submit" value="Submit" class="btn btn-primary trans_eff radius-3">
  </p>
  <?php echo  form_close();?>
</div>
</body>

</html>