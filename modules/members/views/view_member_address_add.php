<?php $this->load->view("top_application");
$account_link = site_url('members/myaccount');
$dn1=$this->input->post('shipping_state')?"":"dn";
$dn2=$this->input->post('shipping_city')?"":"dn";
?>
<div class="container">
<div class="inner-cont">

  <h1>Add New Address</h1>
  
  <?php echo navigation_breadcrumb($title, array('My Account'=>$account_link,'Address'=>'member_address_list/')); ?>
  
  <div class="aj mt5 lht-18">
  <div class="col-xs-12 col-sm-12 col-md-12 cms_area ">
  <?php $this->load->view("members/myaccount_links");?> 
<div class="mt10"> 
  <!-- left ends --> 
  <?php
	    echo error_message();	    	  
		//validation_message();
	  ?>
<div class="acc_mid_boxes">
<form class="form-horizontal contact_form_cont" role="form" method="post" action="<?php echo base_url();?>members/address_add">
<div class="form-group">
<label for="name" class="col-sm-4 control-label">Name <span class="star">*</span></label>  
<div class="col-sm-4">
<input type="text" class="form-control" name="shipping_name" id="shipping_name" value="<?php echo set_value('shipping_name'); ?>" ><?php echo form_error('shipping_name');?></div>
</div>

<div class="form-group">
<label for="name" class="col-sm-4 control-label">Mobile No. <span class="star">*</span></label>  
<div class="col-sm-4">
<input type="text" class="form-control" name="shipping_mobile" id="shipping_mobile" value="<?php echo set_value('shipping_mobile'); ?>" ><?php echo form_error('shipping_mobile');?></div>
</div>

<div class="form-group">
<label for="name" class="col-sm-4 control-label">Phone No.</label>  
<div class="col-sm-4">
<input type="text" class="form-control" name="shipping_phone" id="shipping_phone" value="<?php echo set_value('shipping_phone'); ?>" ><?php echo form_error('shipping_phone');?></div>
</div>


<div class="form-group">
<label for="country" class="col-sm-4 control-label">Country <span class="star">*</span></label>  
<div class="col-sm-4">
<?php
	$country_array=array('name'=>'shipping_country','id'=>'shipping_country','shipping_country'=>$this->input->get_post('shipping_country'),'format'=>'class="form-control changeable" style="" onchange=getstate(this.value,"home/getstate"); ','default_text'=>'Select Country','current_selected_val'=>set_value('shipping_country'));
	echo CountryIdSelectBox($country_array);
?> 
<?php echo form_error('shipping_country');?> 
</div>
</div>
<div class="form-group <?php echo $dn1;?>" id="st">
<label for="state" class="col-sm-4 control-label">State/Region <span class="star">*</span></label>  
<div class="col-sm-4">
	<span id="stateid" style="margin-top:5px;">
		<?php   
        if($this->input->post('shipping_country')!=''){
          $state_array=array('name'=>'shipping_state','id'=>'shipping_state','country_id'=>$this->input->post('shipping_country'),'format'=>' class="form-control changeable" style=" onchange=getcity(this.value,"home/getcity");','default_text'=>'Select State','current_selected_val'=>$this->input->post('shipping_state'));
         echo StateSelectBox($state_array);
        }
        ?>
    </span><?php echo form_error('shipping_state');?></div>
</div>
<div class="form-group <?php echo $dn2;?>" id="ct">
<label for="city" class="col-sm-4 control-label">City <span class="star">*</span></label>  
<div class="col-sm-4">
<span id="cityid" style="margin-top:5px;">
		<?php  
        if($this->input->post('shipping_state')!=''){
          $city_array=array('name'=>'shipping_city','id'=>'shipping_city','state_id'=>$this->input->post('shipping_state'),'format'=>'class="form-control changeable" style="" ','default_text'=>'Select City','current_selected_val'=>$this->input->post('shipping_city'));
         echo CitySelectBoxDropdown($city_array);
        }
        ?>
    </span><?php echo form_error('shipping_city');?></div>
</div>
<div class="form-group">
<label for="mobile" class="col-sm-4 control-label">Address <span class="star">*</span></label>  
<div class="col-sm-4">
<textarea name="shipping_address" id="shipping_address" class="form-control"  rows="3"><?php echo set_value('shipping_address');?></textarea><?php echo form_error('shipping_address');?></div>
</div>
<div class="form-group">
<label for="zip-code" class="col-sm-4 control-label">Zip Code <span class="star">*</span></label>  
<div class="col-sm-4">
<input type="text" name="shipping_zipcode" id="shipping_zipcode" class="form-control" value="<?php echo set_value('shipping_zipcode'); ?>" ><?php echo form_error('shipping_zipcode');?></div>
</div>

<div class="form-group">
<div class="col-sm-8 col-sm-offset-4">
<?php /*?><p class="w62"><span class="db mb10"> <input name="default_address" type="checkbox" value="Y" class="fl mr5 mt3">Make this as your default address</span></span>       
        </p> <?php */?>
<input name="submit" type="submit" class="btn btn4 radius-3 trans_eff" value="Add" >
</div>
</div>

</form>
<div class=" clearfix"></div>
</div>
</div>
<div class=" clearfix"></div>

</div>
    </div>

</div>
</div>
<?php $this->load->view("bottom_application");?>