<?php $this->load->view("top_application");$mtype=$this->mtype;?>
<div class="container pt10 minmax"> 
<div class="row">
<div class="inner-cont">
<h1 class="heading">My Account</h1>   
    
<ul class="breadcrumb">
<li><a href="<?php echo base_url();?>">Home</a></li>
<li class="active">My Account</li>
</ul>

	<div class="mt10">
      <div class="myacc-link">
      <?php $this->load->view("members/myaccount_links");?>      
      </div>
      
      <p style="margin-top:-1px; border-bottom:#e3e3e3 1px solid;"></p>
      <p class="fs11 text-right mt10 text-uppercase">Welcome <?php echo ucwords($mres['first_name']." ".$mres['last_name']);?> <span class="red ml5 bl pl5 mob_hider">Last Login : <?php echo getDateFormat($mres['last_login_date'],7);?></span></p>
	      <div class="cb clearfix"></div>
	<div class="mt20">
		
        <div class="col-lg-6 col-md-6 col-sm-6 fs12 p0 pb40">
        <p class="text-uppercase fs16 b blue">My Profile</p>
        <p class="mt5"><img src="<?php echo theme_url(); ?>images/shadow.png" alt="" class="img-responsive"></p>
        <!--<div class="mem_thm bdr p3"> <figure><img src="<?php echo theme_url(); ?>images/member.png" width="60" height="60"></figure></div>-->
        <p class="b black"><?php echo ucwords($mres['first_name']." ".$mres['last_name']);?></p>
        <p><?php echo $mres['mobile_number'];?></p>
        <p><?php echo $mres['user_name'];?></p>
        <?php
		if($ship_data['name']!=""){?>
        <div class="mt10"><strong>Delivery Information :</strong>   <br>
	<?php echo $ship_data['name'];?> <br>Phone : <?php echo $ship_data['phone'];?> <br>Mobile : <?php echo $ship_data['mobile'];?><br><?php echo $ship_data['address'];?>, <?php echo $ship_data['city'];?>, <?php echo $ship_data['state'];?>, <?php echo $ship_data['country'];?> - <?php echo $ship_data['zipcode'];?></div>
    		<?php
		}?>
        <p class="mt10"><a href="<?php echo base_url();?>members/edit_account" class="btn-style3">Edit</a></p>
        </div>
        
        <div class="col-lg-6 col-md-6 col-sm-6 fs12 p0 pb40">
        <p class="text-uppercase fs16 b blue">Send Your Feedback</p>
        <p class="mt5"><img src="<?php echo theme_url(); ?>images/shadow.png" alt="" class="img-responsive"></p>
        <p class="mt10">Give your feedback to help shoppers on <strong><?php echo $this->config->item('site_name');?></strong> <br />make informed decision.</p>
        <p class="mt30"><a href="<?php echo base_url();?>contact-us" class="btn-style3">Share Feedback Now</a></p>
        </div>
        
        <p class="clearfix"></p>
        
<div class="fs12 mt15 pb40">
 <?php 
    if( is_array($fav_res) && !empty($fav_res)){
    ?>
    <p class="text-uppercase fs16 b blue">My Favorites</p>
    <p class="mt5"><img src="<?php echo theme_url(); ?>images/shadow.png" alt="" class="img-responsive"></p>                
    <?php
    $i=1;
	foreach( $fav_res as $val ){
		$discounted_price = $val[$mtype.'product_discounted_price']>0 && $val[$mtype.'product_discounted_price']!=null ? TRUE : FALSE;
		$link_url = base_url().$val['friendly_url'];
		$condtion = " AND products_id =".$val['products_id']." AND media_type='photo' ORDER BY id ASC LIMIT 1";
		$media = get_db_field_value('wl_products_media',"media",$condtion);
	  ?>    
        <div class="col-lg-3 col-md-4 col-sm-6 ">
            <div class="probox">
            <div class="pro-title">
            <p class="add-cart"><a href="<?php echo $link_url;?>" title="Add to Cart"><img src="<?php echo theme_url(); ?>images/add-cart.png" alt="Add to Cart"></a></p>
            <p><a href="<?php echo $link_url;?>" title="<?php echo $val['product_name'];?>"><?php echo char_limiter($val['product_name'],30);?></a></p>
            </div>
            <p class="pro"><span><a href="<?php echo $link_url;?>" title="<?php echo $val['product_name'];?>"><img src="<?php echo get_image('products',$media,'290','378','R'); ?>" alt="<?php echo $val['product_name'];?>"></a></span></p>
            <p class="pro-price2">
                <?php 
                if($discounted_price===TRUE){?>
                        <del class="fs15 mr5"><?php echo display_price($val[$mtype."product_price"]);?></del>
                        <?php echo  display_price($val[$mtype.'product_discounted_price']);?>
                <?php 
                }else{?>
                        <?php echo  display_price($val[$mtype.'product_price']);?>
                   <?php 
                }?>
               </p>
            </div>
        </div>
      <?php
	  $i++;
	}
	if(count($fav_res) > 4){
	?>
    		<p class="clearfix"></p>
    		<p class="mt10"><a href="<?php echo base_url();?>members/wishlist" class="btn-style3">View All</a></p>
    	<?php
	}
}?>
</div>
        
	<p class="clearfix"></p>
                
	</div>
	
    </div>
    
</div>
</div>
</div>
<?php $this->load->view("bottom_application");?>