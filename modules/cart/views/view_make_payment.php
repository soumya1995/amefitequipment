 <?php $this->load->view("top_application");
//$page_content = get_db_field_value('wl_cms_pages','page_description'," AND friendly_url='make_payment' AND status='1'");
$user_id=($this->session->userdata("user_id")>0)?$this->session->userdata("user_id"):$this->session->userdata("guest");
$user_email = get_db_field_value('wl_customers','user_name'," AND customers_id='$user_id'");

$tax  = ($this->admin_info->tax > 0) ?  $this->admin_info->tax : '0';
$total_tax = ($this->session->userdata('sub_total')*$tax/100);
?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<p class="heading">Payment</p>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li class="active">Payment</li>
</ul>

	<div class="col-lg-7 p0 mt15">
	<div>
    
    <p class="black p10 fs16 bdr" style="background:#eee;">1. Delivery Information</p>
      
      <div class="bdr mt10 pb20">
      <?php echo form_open('cart/make_payment');?>      
        <p class="p10 black fs16" style="background:#ddd;">2. Make Payment</p>
        <div class="m10">
        <p class="black ttu">Select a payment method</p>
        <p class="fs15 verd pt5 b">Total Payable Amount : <b class="red"><?php echo display_price($this->session->userdata('total_amount_payable')+$total_tax);?></b> </p>
      <!--<p class="fs11 verd pt5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text everd since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>-->
      
      <div class="mt25">
      <p class="fl w50 mb10"><label><input name="pay_method" type="radio" value="directPost" checked="checked"> <img src="<?php echo theme_url(); ?>images/mycrd1.png" alt="" class="vam"></label></p>
      <p class="fl w50 mb10"><label><input name="pay_method" type="radio" value="directPost" checked="checked"> <img src="<?php echo theme_url(); ?>images/mycrd4.png" alt="" class="vam" ></label></p>
      <p class="fl w50 mb10"><label><input name="pay_method" type="radio" value="directPost" checked="checked"> <img src="<?php echo theme_url(); ?>images/mycrd3.png" alt="" class="vam" ></label></p>
      <p class="fl w50 mb10"><label><input name="pay_method" type="radio" value="directPost" checked="checked"> <img src="<?php echo theme_url(); ?>images/mycrd5.png" alt="" class="vam" ></label></p>
      <p class="fl w50 mb10"><label><input name="pay_method" type="radio" value="directPost" checked="checked"> <img src="<?php echo theme_url(); ?>images/mycrd2.png" alt="" class="vam" ></label></p>
      <p class="cb"></p>
        </div>
        <p class="cb"></p>
        
        <p class="mt10">
        <input name="submit" type="submit" class="button-style" id="submit" value="Make Payment"/>
      </p>
      
        </div>
        <?php echo form_close();?>
      </div>
      
      
    </div>
    </div>
    
    
    <p class="col-lg-1"></p>
    
    
    <div class="col-lg-4 p0 pt20">
    <br class="mob_only">
     <div>
        <p class="b ml5 ttu pink fs14">Your Cart Items</p>
        <?php $this->load->view("cart/cart_right_view");?>
      </div>
      <div class="mt20"><strong>Delivery Information :</strong>   <br>
	<?php echo $mres['name'];?> <br>Phone : <?php echo $mres['phone'];?> <br>Mobile : <?php echo $mres['mobile'];?><br><?php echo $mres['address'];?>, <?php echo $mres['city'];?>, <?php echo $mres['state'];?>, <?php echo $mres['country'];?> - <?php echo $mres['zipcode'];?></div>
    </div>
    
    <p class="clearfix"></p>

</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>