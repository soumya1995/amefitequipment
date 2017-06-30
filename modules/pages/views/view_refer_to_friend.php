<?php
$uname=$mres['first_name']." ".$mres['last_name'];
?>
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
<body class="p10">
<p class="heading">Refer to a Friend</p>
<?php echo error_message();
 echo  form_open('');
 $current_url=base64_decode($this->input->get('current_ul'));
 if($this->input->post("current_url"))
 $current_url=$this->input->post("current_url");?>
 <input type="hidden" name="current_url" value="<?php echo set_value('current_url',$current_url);?>">
<p class="mt10"><label for="your_name">Your Name <span class="star">*</span></label></p>
    <p> <input name="your_name" id="your_name"  type="text" placeholder="" class="txtbox w95" value="<?php echo set_value('your_name',$uname);?>" maxlength="100" ><?php echo form_error('your_name');?></p>
    <p class="mt10"><label for="your_email">Your Email <span class="star">*</span></label></p>
    <p><input name="your_email" id="your_email"  autocomplete="off" type="text" placeholder="" class="txtbox w95" value="<?php echo set_value('your_email',$mres['user_name']);?>" maxlength="100" ><?php echo form_error('your_email');?></p>
    <p class="mt10"><label for="friend_name">Your Friend's Name <span class="star">*</span></label></p>
    <p><input name="friend_name" id="friend_name"  autocomplete="off" type="text" placeholder="" class="txtbox w95" value="<?php echo set_value('friend_name');?>" maxlength="100"><?php echo form_error('friend_name');?></p>
    <p class="mt10"><label for="friend_email">Your Friend's Email  <span class="star">*</span></label></p>
    <p><input name="friend_email" id="friend_email"  autocomplete="off" type="text" placeholder="" class="txtbox w95" value="<?php echo set_value('friend_email');?>" maxlength="100"><?php echo form_error('friend_email');?></p>

<p class="mt10">
  <input name="verification_code" id="verification_code" type="text" class="p8 radius-3" style="width:120px" placeholder="Enter Code *">
    <img src="<?php echo site_url('captcha/normal'); ?>" class="vam" alt=""  id="captchaimage"/> &nbsp; <a href="javascript:void(0);" title="Change Verification Code"  ><img src="<?php echo theme_url();?>images/refresh-icon.png"  alt="Refresh"  onclick="document.getElementById('captchaimage').src='<?php echo site_url('captcha/normal'); ?>/<?php echo uniqid(time()); ?>'+Math.random(); document.getElementById('verification_code').focus();" class="vam"></a><?php echo form_error('verification_code');?></p>
<p class="mt10">
  <input name="submit" type="submit" class="button-style" value="Send">
</p>
<?php echo  form_close();?>
</body>
</html>
