<?php $this->load->view("top_application");?>
<div class="content">
 <!--Text-->
 <div>
  <h1>Invoice</h1>
  <?php echo navigation_breadcrumb("Invoice");?>
  <div class="lh20px gray1"> 
   <!--Invoice-->
   <?php echo cart_invoice_content();
   echo form_open();?>
   <div class="mt5 ac ">
    <select name="shipping_method"  class="p5 w90" onchange="this.form.submit();">
     <option value="">Select Shipping</option>
     <?php
     $set_shipping_id = $this->session->userdata('shipping_id');
     if(is_array($shipping_methods) && !empty($shipping_methods)){
	     foreach( $shipping_methods as $val ){
		     ?>
		     <option value="<?php echo $val['shipping_id'];?>" <?php if($set_shipping_id==$val['shipping_id']) { ?> selected="selected" <?php } ?> ><?php echo $val['shipping_type'];?> &raquo; <?php echo display_price($val['shipment_rate']);?></option>
		     <?php
	     }
     }?>
    </select><p class="mt10 print"><a href="<?php echo site_url('cart/print_invoice') ?>" class="invoice-pop-np" target="_blank">Print Invoice</a></p>
   </div>
   <?php echo form_error("shipping_method")?>
  </div> 
  <p class="mt10 white ac"><input name="make_payment" type="submit" class="btn-bg" value="Make Payment" /></p>
  <?php echo form_close();?>
 </div>
 <div class="cb"></div>
 <?php $this->load->view("pages/newsletter");?>
 <div class="cb"></div>
</div>
<?php $this->load->view("bottom_application");?>