<?php $this->load->view("top_application");
?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<p class="heading">Invoice</p>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url(); ?>">Home</a></li>
<li class="active">Invoice</li>
</ul>

	<div class="fs14 text-center mt5">
      <p><img src="<?php echo theme_url(); ?>images/thankyou.png" alt=""></p>
      <p class="mt10 pink fs16 ttu">Your order has been placed successfully!</p>
      <p class="mt5">Your Order Information will be sent to your email id (<?php echo $ordmaster['email'];?>)</p>
    </div>
	<?php echo order_invoice_content_thanks($ordmaster,$orddetail);?>
</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>