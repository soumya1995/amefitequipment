<?php $this->load->view('top_application');
?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading">Contact Us</h1>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li class="active">Contact Us</li>
</ul>

	<div class="col-lg-7 col-md-7 p0 input-field">
    <p class="fs18 mt15 blue">General Inquiry<span class="fs13 des_only black">Just Fill the Below Information:</span></p>
    <?php
	echo error_message();
	echo validation_message();
	echo form_open('pages/contactus');?>
      <fieldset class="pt5" style="border:none;">
        <div class="mt10">
          <p class="input-w-l mt4">
            <input type="text" name="first_name" id="first_name" placeholder="First Name *" class="w47" value="<?php echo set_value('first_name');?>" />
            <input type="text" name="last_name" id="last_name" placeholder="Last Name" class="w47 ml2" value="<?php echo set_value('last_name');?>" />
          </p>
          <p class="input-w-r mt4">
          	<input type="text" name="email" id="email" class="w95" placeholder="Email *" value="<?php echo set_value('email');?>">
          </p>
          <p class="mt4 input-w-l">
            <input type="text" name="mobile_number" id="mobile_number" class="w95" placeholder="Mobile Number *" value="<?php echo set_value('mobile_number');?>">
          </p>
          <p class="mt4 input-w-r">
            <input type="text" name="phone_number" id="phone_number" class="w95" placeholder="Phone Number " value="<?php echo set_value('phone_number');?>">
          </p>
          <p class="cb"></p>
          <p class="mt4">
          <textarea name="message" id="message" cols="45" rows="3" class="w97" placeholder="Enquiry/comment *"><?php echo set_value('message');?></textarea>
        </p>
        </div>
        
        <div class="cb pb5"></div>
        <p><input name="verification_code" id="verification _code" type="text" style="width:150px;" placeholder="Word Verification *" value=""><br class="mob_only"><img src="<?php echo site_url('captcha/normal');?>" class="vam p1" alt="" id="captchaimage" /> <a href="javascript:void(0);" title="Change Verification Code"><img src="<?php echo theme_url();?>images/refresh-icon.png"  alt="Refresh"  onclick="document.getElementById('captchaimage').src='<?php echo site_url('captcha/normal');?>/<?php echo uniqid(time());?>'+Math.random(); document.getElementById('verification_code').focus();" class="vam ml10"></a>
              <p class="grey pt5 fs11">Type the characters shown above.</p>
        </p>
        <div class="mt10">
          <input name="submit" type="submit"  value="Submit" class="button-style">
          <input name="reset" type="reset" value="Reset" class="button-style">
        </div>
      </fieldset>
      <?php echo form_close();?>
    </div>
    
    <p class="col-lg-1 col-md-1"></p>    
    
    <div class="col-lg-4 col-md-4 p0">
	<?php echo $content;?>    
    </div>
    
    
    <p class="clearfix"></p>
    
    
</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>