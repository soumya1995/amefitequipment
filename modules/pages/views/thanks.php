<?php $this->load->view("top_application");
?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading">Thank You</h1>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url(); ?>">Home</a></li>
<li class="active">Thank You</li>
</ul>

	<div class="fs14 text-center mt5">
      <p><img src="<?php echo theme_url(); ?>images/thankyou.png" alt=""></p>
      <p class="mt10 pink fs16 ttu"><?php echo error_message();?></p>
      <p class="mt15"><a href="<?php echo base_url();?>" class="btn btn-lg btn-default radius-3">Go Back</a></p>
    </div>
</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>