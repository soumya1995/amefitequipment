<?php $this->load->view("top_application");
?>
<script type="text/javascript">function serialize_form() { return $('#myform').serialize(); } </script>
<div class="container">
<div class="inner-cont">

  <h1>Manage Address</h1>
  
  <?php echo navigation_breadcrumb("My Addresses"); ?>
  
  <div class="aj mt5 lht-18">
  <div class="col-xs-12 col-sm-12 col-md-12 cms_area ">
  <?php $this->load->view("members/myaccount_links");?> 
<div class="mt10"> 
  <!-- left ends --> 
<?php echo form_open('members/member_address_list','id="myform"') ; ?>
<div  id="my_data"> 
<div class="acc_mid_boxes">
<p class="pull-right"><a href="<?php echo base_url();?>members/address_add" class="btn btn2">+ Add New Address</a></p>
<div class="clearfix"></div>

<?php		 
echo error_message(); 
	if( is_array($amres) && !empty($amres)){
	?>
            
<div class="mt10 t_option hidden-xs">
<div class="row">
<div class="col-sm-2 col-md-2 col-lg-2">S. No.</div>
<div class="col-sm-8 col-md-8 col-lg-8">Addresses</div>
<div class="col-sm-2 col-md-2 col-lg-2 text-center">Action</div>
<div class=" clearfix"></div>
</div>  
</div>
<?php
	$sl=1;
	foreach($amres as $aVal){ 
	?>         
    <div class="odr-his text">  
        <div class="row">
        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"><strong>S. No.</strong> <?php echo $sl;?>.</div>
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"> 
        <p class="inv_ttl_2"><?php echo $aVal['name'];?> </p>
        <p class=""><b>Mobile:</b> <?php echo $aVal['mobile'];?>  / <b>Phone:</b> <span><?php echo $aVal['phone'];?></span><br></p>
        <p><?php echo $aVal['address'];?>, <?php echo $aVal['city'];?>, <?php echo $aVal['state'];?> - <?php echo $aVal['zipcode'];?>,  <?php echo strtoupper($aVal['country']);?></p>
        </div>
        
        <div class="col-xs-12 col-sm-2 text-center black ttu fs14 edt-opt"> <b class="visible-xs-inline">Action :</b> <a href="<?php echo base_url();?>members/address_edit/<?php echo $aVal['address_id'];?>" title="Edit"> <img src="<?php echo theme_url(); ?>images/icn_4.png" alt=""></a> <a href="<?php echo base_url();?>members/member_address_list/<?php echo $aVal['address_id'];?>?del=delete" onclick="return confirm('Are you sure you want to remove this address?');" title="Delete" > <img src="<?php echo theme_url(); ?>images/icn_2.png" alt="" class="ml10"></a></div>        
        <div class=" clearfix"></div>
        </div>
    </div>
    <!-- list 1 -->
    	<?php
	$sl++;
	}
	?>
    <?php
		}else{
			?>
			<div class="cb pb15"></div>
			<div class="b mt10" align="center">No record(s) available</div>
			<div class="cb pb15"></div>
			<?php
	}
?> 

</div>

<div class="paging_cont">


<div class="col-sm-12 text-center"> 
    <ul class="pagination"><?php echo $page_links; ?></ul>
</div> 
</div>
<div class=" clearfix"></div>
 </div>
<?php echo form_close(); ?> 
</div>

<div class=" clearfix"></div>

</div>
    </div>

</div>
</div>
<?php $this->load->view("bottom_application");?>