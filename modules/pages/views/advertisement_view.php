<?php $this->load->view("top_application");
echo navigation_breadcrumb('Advertise With Us');?>
<section class="wrapper D_pl10 D_pr10" style="min-height:600px">
 <div class="pt20">
  <h1 class="pb5">Advertise With Us</h1>
  <div class="contact_box2">
   <div class="contact_form_cont">
    <h2 class="S_fs20 S_lh24">Still need help? <br class="dn S_show"><b>Send Your Advertisement Enquiry</b></h2>
    <?php echo error_message();
    //echo validation_errors();
    ?>
    <a id="feedback"></a>
    <?php
    echo form_open_multipart(base_url().'advertisement'.$this->config->item("url_suffix").'#adv')?>
    <fieldset class="contact_form" style="border:none;">
     <div class="mt5"><input type="text" name="first_name" id="first_name" placeholder="Your Name *" value="<?php echo set_value('first_name');?>"><?php echo form_error('first_name');?></div>
     <div class="mt5"><input type="text" name="company_name" id="company_name" placeholder="Company Name *" value="<?php echo set_value('company_name');?>"><?php echo form_error('company_name');?></div>
     <div class="mt5"><input type="text" name="email" id="email" placeholder="Email *" value="<?php echo set_value('email');?>"><?php echo form_error('email');?></div>
     <div class="mt5"><input type="text" name="mobile_number" id="mobile_number" placeholder="Mobile Number *" value="<?php echo set_value('mobile_number');?>"><?php echo form_error('mobile_number');?></div>
     <div class="mt5"><input type="text" name="phone_number" id="phone_number" placeholder="Phone Number" value="<?php echo set_value('phone_number');?>"><?php echo form_error('phone_number');?></div>
     <div class="mt5"><input type="file" name="image1" id="image1" placeholder="Upload Banner"><?php echo form_error('image1');?></div>
     <div class="mt5"><input type="text" name="banner_url" id="banner_url" placeholder="Banner URL" value="<?php echo set_value('banner_url');?>"><?php echo form_error('banner_url');?></div>
     <?php $this->load->helper('array');?>
     <div class="mt5">
      <?php echo form_dropdown('banner_position',banner_type_array(),$this->input->get_post('banner_position'),'class=""');
      echo form_error('banner_position');?>
     </div>
     <div class="mt5"><textarea name="description" id="description" cols="45" rows="5" placeholder="Website Description *"><?php echo set_value('description');?></textarea><?php echo form_error('description');?></div>
     <div class="mt5">
      <input name="verification_code" id="verification_code" type="text" placeholder="Enter Code *" class="vam" style="width:150px">
      <img src="<?php echo base_url()?>captcha/normal" id="captchaimage" alt="" class="vam"> <a href="javascript:void(0);" ><img onclick="document.getElementById('captchaimage').src='<?php echo base_url('captcha/normal'); ?>/<?php echo uniqid(time()); ?>'+Math.random(); document.getElementById('verification_code').focus();"  src="<?php echo theme_url()?>images/ref.png" alt="" class="vam"></a>
      <?php echo form_error("verification_code")?>
      <p class="grey pt5 fs11">Type the characters shown above.</p>
     </div>
     <div class="mt10">
      <input name="submit" type="submit" value="Submit" class="btn2 trans_eff radius-3 vam">
      <input name="reset" type="reset" value="Reset" class="btn3 trans_eff radius-3 vam">
     </div>
    </fieldset>
    <?php echo form_close();?>
   </div>
  </div>
  <div class="cb"></div>
 </div>
</section>
<?php $this->load->view("bottom_application");?>