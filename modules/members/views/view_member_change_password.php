<?php $this->load->view("top_application");
?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading">Change Password</h1>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li><a href="<?php echo base_url();?>members/myaccount">My Account</a></li>
<li class="active">Change Password</li>
</ul>

	<div class="mt10">
      <div class="myacc-link">
      <?php $this->load->view("members/myaccount_links");?>
      </div>
      
      <p style="margin-top:-1px; border-bottom:#e3e3e3 1px solid;"></p>
       <p class="fs11 text-right mt10 text-uppercase">Welcome <?php echo ucwords($mres['first_name']." ".$mres['last_name']);?> <span class="red ml5 bl pl5 mob_hider">Last Login : <?php echo getDateFormat($mres['last_login_date'],7);?></span></p>
	      
		<div class="mt20">
        <?php
	echo error_message();	    	  
	validation_message();
?>
  <p class="clearfix"></p>
            <div class="acc-box">
            <?php 
    			echo form_open('members/change_password');?>
                <p class="input-w-l mb7">
                <input type="password" autocomplete="off" name="old_password" id="old_password" type="text" class="bgW bdr p8 w95" placeholder="Enter Old Password" value="<?php echo set_value('old_password');?>">
                </p>
                <p class="clearfix"></p>
                <p class="input-w-l mb7">
                <input type="password" autocomplete="off" name="new_password" id="new_password" type="text" class="bgW bdr p8 w95" placeholder="Enter New Password" value="<?php echo set_value('new_password');?>">
                </p>
                <p class="input-w-r mb7">
                <input type="password" autocomplete="off" name="confirm_password" id="confirm_password" type="text" class="bgW bdr p8 w95" placeholder="Enter Confirm Password" value="<?php echo set_value('confirm_password');?>">
                </p>
                
                <p class="mt15">
                <input name="submit" type="submit" class="button-style" value="Update">
                </p>
              <?php echo form_close();?>
            </div>
		</div>
				
    </div>
    
</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>