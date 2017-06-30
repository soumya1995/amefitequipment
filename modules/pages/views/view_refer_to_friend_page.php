<?php $this->load->view('top_application');?>
<div class="content"> 
 <!--Text-->
 <div>
  <h1>Refer To Friend</h1>
  <?php echo navigation_breadcrumb("Refer To Friend");?>
  <div class="lh20px gray1 form-style"> 
   <div class="mt10">
    <?php echo error_message();
    echo  form_open('');
    $current_url=base64_decode($this->input->get('current_ul'));
    if($this->input->post("current_url"))
    $current_url=$this->input->post("current_url");?>
    <input type="hidden" name="current_url" value="<?php echo set_value('current_url',$current_url);?>">
    <div class="input-left"><input name="your_name" id="your_name"  autocomplete="off" type="text" class="p5 w90" autocomplete="off"  placeholder="Name * " value="<?php echo set_value('your_name');?>" maxlength="100"><?php echo form_error('your_name');?></div>
    <div class="input-right"><input name="your_email" id="your_email" autocomplete="off" type="text" class="p5 w90" autocomplete="off"  placeholder="Your Email * " value="<?php echo set_value('your_email');?>" maxlength="100"><?php echo form_error('your_email');?></div>
    <div class="cb"></div>
    <div class="input-left"><input name="friend_name" id="friend_name" autocomplete="off" type="text" class="p5 w90" autocomplete="off"  placeholder="Your Friends Name * " value="<?php echo set_value('friend_name');?>" maxlength="100" ><?php echo form_error('friend_name');?></div>
    <div class="input-right"><input name="friend_email" id="friend_email" autocomplete="off" type="text" class="p5 w90" autocomplete="off"  placeholder="Your Friends Email * " value="<?php echo set_value('friend_email');?>" maxlength="100" ><?php echo form_error('friend_email');?></div>
    <div class="cb"></div>
    <div class="input-left"><input name="verification_code" type="text" id="WORD" placeholder="Word Verification" class="w50 mr10"> <img src="<?php echo site_url('captcha/normal'); ?>" class="vam" alt=""  id="captchaimage"/> <a href="javascript:void(0);" title="Change Verification Code"  ><img src="<?php echo theme_url(); ?>images/ref12.png"  alt="Refresh"  onclick="document.getElementById('captchaimage').src='<?php echo site_url('captcha/normal'); ?>/<?php echo uniqid(time()); ?>'+Math.random(); document.getElementById('verification_code').focus();" class="ml10 vam"></a><?php echo form_error('verification_code');?></div>
    <div class="cb"></div>
    <p class="mb10 mt10"><input type="submit" name="submit" id="submit" value="Submit" class="btn-bg" ></p>
    <?php echo  form_close();?>
   </div>
  </div>
  <!--Login-->
 </div>
 <!--Text--> 
 <div class="cb"></div> 
 <?php $this->load->view("pages/newsletter");?>
 <div class="cb"></div>
</div>
<?php $this->load->view("bottom_application");?>  