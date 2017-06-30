<?php $this->load->view("top_application");
$account_link = site_url('members/myaccount');
$mtype=$this->mtype;
?>
<script type="text/javascript">function serialize_form() { return $('#myform').serialize(); } </script>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading">My Favorites</h1>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li><a href="<?php echo base_url();?>members/myaccount">My Account</a></li>
<li class="active">My Favorites</li>
</ul>

	<div class="mt10">
      <div class="myacc-link">
      <?php $this->load->view("members/myaccount_links");?>
      </div>
      
      <p style="margin-top:-1px; border-bottom:#e3e3e3 1px solid;"></p>
      <p class="fs11 text-right mt10 text-uppercase">Welcome <?php echo ucwords($mres['first_name']." ".$mres['last_name']);?> <span class="red ml5 bl pl5 mob_hider">Last Login : <?php echo getDateFormat($mres['last_login_date'],7);?></span></p>
	      
	<div class="mt20">
    <?php echo validation_message(); echo error_message(); ?>
	<div class="form_box" id="form_1">
    <?php	 
	if( is_array($res) && !empty($res) ){ ?>
    <div class="cart-head">
    	<p class="order-tab1">S. No.</p>
        <p class="order-tab2">Product Name</p>
        <p class="order-tab3">Amount</p>
        <p class="order-tab4">Date</p> 
        <p class="order-tab5">Buy Now</p>
        <p class="order-tab6">Delete</p>        
        <p class="cb"></p>
    </div>
    <?php		   
		$i=1;
		foreach( $res as $val ){
			$link_url = base_url().$val['friendly_url'];
			$condtion = " AND products_id =".$val['products_id']." AND media_type='photo' ORDER BY id ASC LIMIT 1";
			$media = get_db_field_value('wl_products_media',"media",$condtion);
	  ?>
        <div class="cart-list">
            <p class="order-tab1"><?php echo $i;?>.</p>
            <p class="order-tab2 blue u"><span class="b black mob_only">Product Name<br></span><a href="<?php echo $link_url;?>"><?php echo $val['product_name']." (".$val['product_code'].") ";?> </a></p>
            <p class="order-tab3"><span class="b mob_only">Amount<br></span><?php echo display_price($val[$mtype."product_price"]);?></p>
            <p class="order-tab4"><span class="b mob_only">Date<br></span><?php echo getDateFormat($val['wishlists_date_added'],1);?></p> 
            <p class="order-tab5 blue u"><a href="<?php echo $link_url;?>">Buy Now</a></p>
            <p class="order-tab6"><a href="<?php echo base_url();?>members/remove_wislist/<?php echo $val['wishlists_id'];?>" onclick="return confirm('Are you sure you want to remove this product from your favorite list?');" title="Delete Record"><img src="<?php echo theme_url(); ?>images/delete.png" alt="Delete"></a></p>        
            <p class="cb"></p>
        </div>
	   <?php 
		$i++;
		  }
		}else
		{
		  echo '<div class="mt7 b ac ">'.$this->config->item('no_record_found').'</div>'; 
		}
	?> 
	</div>
		
    </div>
    
</div>
</div>
</div>
</div>
<?php
echo form_open(base_url()."members/wishlist",'id="ord_frm"');?>
<input type="hidden" name="keyword" value="<?php echo $this->input->post('keyword');?>" />
<input type="hidden" name="per_page" class="per_page" value="<?php echo $per_page;?>" />
<?php echo form_close();?>
<script type="text/javascript">
$(document).ready(function(){
	jQuery('[id ^="per_page"]').live('change',function(){
		$("[id ^='per_page'] option[value=" + jQuery(this).val() + "]").attr('selected', 'selected'); 
		
		jQuery(".per_page").val(jQuery(this).val());
		jQuery('#ord_frm').submit();
	});
});
</script>
<?php $this->load->view("bottom_application");?>