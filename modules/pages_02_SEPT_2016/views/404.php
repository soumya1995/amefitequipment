<?php $this->load->view("top_application");?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading">Page not Found!!</h1>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li class="active">Page not Found!!</li>
</ul>

	<div class="text-center mt20"><img src="<?php echo theme_url(); ?>images/404.gif" alt="" class="pagenot"></div>
</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>