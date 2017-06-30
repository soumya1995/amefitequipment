<?php echo form_open('pages/join_newsletter','name="newsletter" id="chk_newsletter" onsubmit="return join_newsletter();" ') ;?> 
<div class="newsletter newsletter-desktop">
 <!--Left-->
 <div class="newsletter-left">
  <p class="treb fs22 ttu white">Newsletter</p>
  <p class="fs12 white">Enter your email address to sign up for our special offers and product promotions</p>
 </div>
 <!--Left--> 
 <!--Right-->
 <div class="newsletter-right">
  <div class="input-left"><input name="subscriber_name" id="subscriber_name" type="text" placeholder="Name *" class="w97" autocomplete="off" /></div>
  <div class="input-right"><input name="subscriber_email" id="subscriber_email" type="text" placeholder="Email Address *" class="w97" autocomplete="off" /></div>
  <div class="cb"></div>
  <div class="input-left">
   <img src="<?php echo site_url('captcha/normal');?>" class="vam mr5" alt="" id="captchaimage1"/>
   <input name="verification_code" id="verification_code1" type="text" placeholder="Enter Code" class=" w32" autocomplete="off" value="" />
   <a href="javascript:void(0);" title="Change Verification Code"><img src="<?php echo theme_url(); ?>images/ref-icon.jpg" alt="Refresh" onclick="document.getElementById('captchaimage1').src='<?php echo site_url('captcha/normal'); ?>/<?php echo uniqid(time()); ?>'+Math.random(); document.getElementById('verification_code1').focus();" class="vam ml5"  id="refresh"></a>
  </div>
  <div class="input-right">
   <input name="subscribe" type="submit" value="Subscribe" class="button" onclick="document.getElementById('saction').value='Y'" />
   <input name="unsubscribe" type="submit" value="Unsubscribe" class="button" onclick="document.getElementById('saction').value='N'" />
   <input name="subscribe_me" type="hidden" id="saction" value="" />
  </div>
  <div class="cb"></div>
  <div  id="my_newsletter_msg" class="mt5 ft-18"></div>
 </div>
 <div class="cb"></div>
 <div  id="my_newsletter_msg" class="mt5 ft-18"></div>
</div>
<?php echo form_close();?>