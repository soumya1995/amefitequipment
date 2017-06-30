<?php $this->load->view("top_application");
$values_posted_back=(is_array($this->input->post())) ? TRUE : FALSE;
$is_same = $values_posted_back === TRUE ? $this->input->post('is_same') : '';
?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<p class="heading">Delivery Info</p>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url(); ?>">Home</a></li>
<li class="active">Delivery Info</li>
</ul>

	<div class="col-lg-7 p0 mt15">
	<div>    
      <?php echo error_message();?>
      <div class="bdr">      
        <p class="p10 blue2 fs14 text-uppercase" style="background:#eee;">1. Delivery Information</p>
        <div class="p15">
        <form name="chkout" id="chkout" method="post" action="<?php echo base_url();?>cart/checkout" class="form-horizontal" role="form">   
            <div class="p2">
            <p class="mb5"><input type="text" placeholder="Name*" name="shipping_name" id="shipping_name" class="txtbox w100" value="<?php echo set_value('shipping_name',$mres['shipping_name']); ?>" ><?php echo form_error('shipping_name');?></p>
            
            <p class="mb5"><textarea name="shipping_address" id="shipping_address" rows="3" class="txtbox w100" placeholder="Address*"><?php echo set_value('shipping_address',$mres['shipping_address']);?></textarea><?php echo form_error('shipping_address');?></p>
            <p class="mb5"><?php echo CountrySelectBox(array('name'=>'shipping_country','format'=>'class="txtbox w100"','current_selected_val'=>set_value('shipping_country',$mres['shipping_country']) )); ?><?php echo form_error('shipping_country');?></p>
            <p class="mb5"><input type="text"  name="shipping_state" id="shipping_state" class="txtbox w100" placeholder="State*" value="<?php echo set_value('shipping_state',$mres['shipping_state']); ?>" ><?php echo form_error('shipping_state');?></p>
            <p class="mb5"><input type="text"  name="shipping_city" id="shipping_city" class="txtbox w100" placeholder="City*" value="<?php echo set_value('shipping_city',$mres['shipping_city']); ?>" ><?php echo form_error('shipping_city');?></p>
           <p class="mb5"> <input type="text"  name="shipping_zipcode" id="shipping_zipcode" class="txtbox w100" placeholder="Zip Code*" value="<?php echo set_value('shipping_zipcode',$mres['shipping_zipcode']); ?>" ><?php echo form_error('shipping_zipcode');?></p>
           <p class="mb5"><input type="text"  name="shipping_mobile" id="shipping_mobile" class="txtbox w100" placeholder="Mobile*" value="<?php echo set_value('shipping_mobile',$mres['shipping_mobile']); ?>" ><?php echo form_error('shipping_mobile');?></p>
            <p class="mb5"><input type="text"  name="shipping_phone" id="shipping_phone" class="txtbox w100" placeholder="Phone" value="<?php echo set_value('shipping_phone',$mres['shipping_phone']); ?>" ><?php echo form_error('shipping_phone');?></p>
            
            </div>
            
            <p class="mt5"><input name="submit" type="submit" class="button-style" value="Proceed"></p>
       </form>  
       </div>
      </div>
      
      <!-- slide 2 -->
      
      <div class=" mt10">
        <p class="black p10 fs16 bdr" style="background:#eee;">2. Make Payment</p>
      </div>
      
      <!-- slide 2 --> 
      
    </div>
    </div>
    
    
    <p class="col-lg-1"></p>
    
    
    <div class="col-lg-4 p0 pt20">
    <br class="mob_only">
     <div>
        <p class="b ml5 ttu pink fs14">Your Cart Items</p>
        <?php $this->load->view("cart/cart_right_view");?>
      </div>
    </div>
    
    
    <p class="clearfix"></p>

</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>