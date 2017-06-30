<?php $this->load->view("top_application");
?>
<div class="container pt10 minmax">
  <div class="row">
    <div class="inner-cont">
      <h1 class="heading">Edit Account</h1>
      <ul class="breadcrumb">
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li><a href="<?php echo base_url();?>myaccount">My Account</a></li>
        <li class="active">Edit Account</li>
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

        <form name="edit_acc" id="edit_acc" method="post" action="">
		<input type="hidden" name="action" id="action" value="edit_account" />
          <div class="acc-box">
          <?php validation_message();?>
            <div>
              <p class="text-uppercase fs14 blue mb8">Personal Information</p>
              <p class="input-w-l mb7">
                <input  name="first_name" id="first_name" class="bgW bdr p8 w95" placeholder="First Name *" type="text" value="<?php echo set_value('first_name',$mres['first_name']); ?>">
              </p>
              <p class="input-w-r mb7">
                <input  name="last_name" id="last_name" class="bgW bdr p8 w95" placeholder="Last Name *" type="text" value="<?php echo set_value('last_name',$mres['last_name']); ?>"></p>
              <p class="clearfix"></p>
              <p class="input-w-l mb7">
                <input  name="mobile_number" id="mobile_number" class="bgW bdr p8 w95" placeholder="Mobile *" type="text" value="<?php echo set_value('mobile_number',$mres['mobile_number']); ?>">
              </p>
              <p class="input-w-r mb7">
                <input  name="phone_number" id="phone_number" class="bgW bdr p8 w95" placeholder="Phone" type="text" value="<?php echo set_value('phone_number',$mres['phone_number']); ?>">
              </p>
              <p class="clearfix"></p>             
            </div>
            <p class="cb"></p>
          </div>
          <br>
          <div class="acc-box">
            <div>
              <p class="text-uppercase fs14 blue mb8">Delivery Information</p>
              <p class="input-w-l mb7">
                <input  name="name" id="name" class="bgW bdr p8 w95" placeholder="Name *" type="text" value="<?php echo set_value('name',$ship_data['name']); ?>">
              </p>
              <p class="input-w-r mb7"></p>
              <p class="clearfix"></p>
              <p class="mb7">
                <textarea rows="2" class="bgW bdr p8 w97" name="address" id="address" placeholder="Address *"><?php echo set_value('address',$ship_data['address']); ?></textarea>
              </p>
              <p class="input-w-r mb7">
                <?php echo CountrySelectBox(array('name'=>'country','format'=>'class="txtbox w95"','current_selected_val'=>set_value('country',$ship_data['country']) )); ?>
              </p>
              <p class="input-w-r mb7">
                <input type="text"  name="state" id="state" class="bgW bdr p8 w95" placeholder="State*" value="<?php echo set_value('state',$ship_data['state']); ?>" >
              </p>
              <p class="clearfix"></p>
              <p class="input-w-l mb7">
                <input type="text"  name="city" id="city" class="bgW bdr p8 w95" placeholder="City*" value="<?php echo set_value('city',$ship_data['city']); ?>" >
              </p>
              <p class="input-w-r mb7">
                <input type="text"  name="zipcode" id="zipcode" class="bgW bdr p8 w95" placeholder="Zip Code*" value="<?php echo set_value('zipcode',$ship_data['zipcode']); ?>" >
              </p>
              <p class="input-w-l mb7">
                <input type="text"  name="mobile" id="mobile" class="bgW bdr p8 w95" placeholder="Mobile*" value="<?php echo set_value('mobile',$ship_data['mobile']); ?>" >
              </p>
              <p class="input-w-r mb7">
                <input type="text"  name="phone" id="phone" class="bgW bdr p8 w95" placeholder="Phone*" value="<?php echo set_value('phone',$ship_data['phone']); ?>" >
              </p>
              <p class="clearfix"></p>  
            </div>
            
            <p class="cb"></p>
            <p class="mt10">
              <input name="submit" type="submit" class="button-style" value="Update">
              <input name="reset" type="reset" class="button-style" value="Reset">
            </p>
          </div>
          <br>
         </form> 
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->load->view("bottom_application");?>