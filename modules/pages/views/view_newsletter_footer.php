<div  id="my_newsletter_msg" class="newsletter_form">
<?php echo form_open('pages/join_newsletter_footer','name="chk_newsletter" id="chk_newsletter"');?>
        <div class="botlink news-let">
    <div class="mb5">
    	<input style="color:#000;" autocomplete="off" name="subscriber_name" id="subscriber_name" type="text" placeholder="Your Name *" value="<?=set_value('subscriber_name');?>"/><?=form_error('subscriber_name');?>
    </div>
    <div class="mb5">
    	<input style="color:#000;" autocomplete="off" name="subscriber_email" id="subscriber_email" type="text" placeholder="Email ID *" value="<?=set_value('subscriber_email');?>"/><?=form_error('subscriber_email');?>
    </div>
	<div class="mb5">
    	<input style="color:#000;" autocomplete="off" name="subscriber_phone" id="subscriber_phone" type="text" placeholder="Phone *" value="<?=set_value('subscriber_phone');?>"/><?=form_error('subscriber_phone');?>
    </div>
    <div class="mb5">
    <input autocomplete="off" name="verification_code_news" id="verification_code_news" type="text" placeholder="Write the code " class="w50" style="width:50%;color:#000;"> 
      <img src="<?php echo base_url().'captcha/normal'; ?>" alt="" id="captchaimage_news"/> 				
                <a class="w10 fr mr32" href="javascript:void(0);" title="Change Verification Code"  ><img src="<?php echo theme_url(); ?>images/ref.png"  alt="Refresh"  onclick="document.getElementById('captchaimage_news').src='<?php echo base_url().'captcha/normal'; ?>/<?php echo uniqid(time()); ?>'+Math.random(); document.getElementById('verification_code_news').focus();" width="34" height="34"></a><?php echo form_error('verification_code_news');?>
                </div>      
      <input type="hidden" name="subscribe_me" id="subscribe_me" value="" />
    	<input type="submit" name="subscribe_me_submit" onclick="$('#subscribe_me').val('Y');" class="btn-style2" style="padding:0 15px;" value="Subscribe" > 
        <input type="submit" name="unsubscribe_me_submit" onclick="$('#subscribe_me').val('N');" class="btn-style2" style="padding:0 15px;" value="Unsubcribe">
    </div>
        <?php echo form_close();?>
		</div>
        <script type="text/javascript">
	var sub_frm = $('#chk_newsletter');
	$('input[type="submit"]',sub_frm).click(function(e) {
		e.preventDefault();
		join_newsletter();        
    });
	</script>