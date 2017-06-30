<?php $this->load->view("top_application");
$page_content = get_db_field_value('wl_cms_pages','page_description'," AND friendly_url='make_payment' AND status='1'");
?>
<div>

<!--Starts-->
<div>
<div>
	<div class="bdrBtm1">
    <h1>Thank You</h1>
    </div>
    <p class="tree"><a href="<?php echo base_url();?>">Home</a> Thank You</p>
    <div class="ac mt22 lh18px">
   
      <p class="pt5 fs16 orange">Your order has been submitted successfully.</p>
      <p class="mt10 black">Your order invoice has been sent to your email.</strong></p>
      <div class="mt10 black"><?php echo $page_content; ?></div>

    </div>
</div>
</div>
<!--Ends-->
<div class="cb"></div>
</div>
  <div class="cb"></div>
    <!--Container-Ends--></div>
    <div class="cb"></div>
<?php $this->load->view("bottom_application");?>