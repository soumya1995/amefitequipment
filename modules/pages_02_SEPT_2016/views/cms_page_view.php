<?php $this->load->view("top_application");
?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading"><?php echo $content['page_name'];?></h1>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li class="active"><?php echo $content['page_name'];?></li>
</ul>

	<div class="aj mt10 cms"><?php echo $content['page_description'];?></div>
</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>