<?php
$this->load->view("top_application");
$mtype=$this->mtype;
$this->load->view("header_images/top_header_images");
?>
<!--Section-->
<div class="clearfix"></div>
<div class="container pt50 pb50 minmax">
<div class="row">	
	<div class="col-lg-4 col-md-4 col-xs-4 p0">
	 <?php
	if( is_array($tres_array) && !empty($tres_array) ){
		
		for($i=0; $i<count($tres_array); $i++){		
			?>
    <div class="sec-area">
    <p><a href="testimonials.htm" title="Testimonials"><img src="<?php echo theme_url();?>images/testimonial-icon.png" alt="Testimonials" class="sec-icon"></a></p> 
    <div class="hidden-xs">   
    <p class="fs20 b text-uppercase mt10">Testimonials</p>
    <p><img src="<?php echo theme_url();?>images/arr2.jpg" alt=""></p>
    <p class="lht-22 mt10 o-hid" style="font-weight:300; height:130px;"><?php echo char_limiter($tres_array[$i]['testimonial_description'],250,"...");?></p>
    <p class="mt10 fs16 b">- <?php echo ucfirst($tres_array[$i]['poster_name']);?></p>
    <p class="mt20"><a href="<?php echo base_url();?>testimonials" class="btn-style" title="Testimonials">Browse More</a></p>
    </div>
    </div>
	<?php
			}
	}?>
    </div>
    
    <div class="col-lg-4 col-md-4 col-xs-4 p0">
    <div class="sec-area">
    <p><a href="<?php echo base_url();?>about-us" title="Welcome"><img src="<?php echo theme_url(); ?>images/welcome-icon.png" alt="Welcome" class="sec-icon"></a></p>    
    <div class="hidden-xs">
    <p class="fs20 b text-uppercase mt10">Welcome</p>
    <p><img src="<?php echo theme_url(); ?>images/arr2.jpg" alt=""></p>
    <p class="lht-22 mt10" style="font-weight:300;"><?php echo char_limiter($content,400);?> </p>
		<p class="mt20"><a href="<?php echo base_url();?>about-us" class="btn-style" title="Testimonials">Browse More</a></p>
  <!--  <p class="mt15 fs16 b">Here at AME, the <br> customer always comes first. </p>-->
    </div>
    </div>
    </div>
    
    <div class="col-lg-4 col-md-4 col-xs-4 p0">
    <div class="sec-area" style="border:0;">
    <p><a href="<?php echo base_url();?>contact-us" title="Contact Us"><img src="<?php echo theme_url(); ?>images/contact-icon.png" alt="Contact Us" class="sec-icon"></a></p>   
    <div class="hidden-xs"> 
    <p class="fs20 b text-uppercase mt10">Contact Us</p>
    <p><img src="<?php echo theme_url(); ?>images/arr2.jpg" alt=""></p>
    <p class="lht-22 mt10" style="font-weight:300;"><?php echo $this->config->item('site_name');?>  <br><?php echo $this->admin_info->address;?> </p>
    <p class="mt20"><a href="<?php echo base_url();?>contact-us" class="btn-style" title="Browse More">Browse More</a></p>
    </div>
    </div>
    </div>
    
    <p class="clearfix"></p>
</div>
</div>
<!--Section end-->

<!--Featured Products-->
<?php
if( is_array($new_product) && !empty($new_product) ){?>
<div class="featured-bg minmax pb25">
<div class="container">

<p class="new-arrival">New Arrivals</p>
    
<div class="mt20 o-hid pro_h">
    <div class="new_scroll">
    <div class="arrival_list">
    <ul>
    <?php
	foreach($new_product as $val){
		
		$link_url = base_url().$val['friendly_url'];
		$discounted_price = $val[$mtype.'product_discounted_price']>0 && $val[$mtype.'product_discounted_price']!=null ? TRUE : FALSE;
		$prodImage=get_image('products',$val["media"],'290','378');
		if($val['product_alt'] !=""){
			$alt_tag=$val['product_alt'];
		}else{
			$alt_tag=$val['product_name'];
		}
		$cond="AND 	products_id = '".$val['products_id']."'";
		$stock_cnt=get_product_stock($cond);
		?>
    <li><div class="probox">
	 <?php if($stock_cnt>0){?>
            
                <?php }else{?>
                <p class="abs"><img src="<?php echo theme_url();?>images/water-sold.png" alt=""></p>
                <?php }?>
    <div class="pro-title white">
    <p class="add-cart"><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><img src="<?php echo theme_url(); ?>images/add-cart.png" width="42" height="42" alt="<?php echo $alt_tag;?>"></a></p>
    <p><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><?php echo char_limiter($val['product_name'],55);?></a></p>
    </div>
    <p class="pro"><span><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><img src="<?php echo $prodImage;?>" alt="<?php echo $alt_tag;?>"></a></span></p>
    <p class="pro-price"> <span class="fs15 hidden-xs"><?php echo char_limiter($val['product_name'],30);?><br /></span> <?php 
                if($discounted_price===TRUE){?>
                       <del class="fs15 mr5"><?php echo display_price($val[$mtype."product_price"]);?></del>
                        <?php echo  display_price($val[$mtype.'product_discounted_price']);?>
                <?php 
                }else{?>
                        <?php echo  display_price($val[$mtype.'product_price']);?>
                   <?php 
                }?></p>
    </div></li>
    <?php
	}?>
    </ul>
    <div class="clearfix"></div>
    </div>
    
  </div>
    
    </div>
    
<p class="text-center mt10"><a href="javascript:void(0);" onclick="return search_form_submit('new_arrival');" title="Browse More" class="btn-style2">Browse More</a></p>

</div>
</div>
	<?php
}?>
<!--Featured Products end-->

<!--Hot Products-->
<?php
if( is_array($hot_product) && !empty($hot_product) ){?>
<div class="container pt30 pb30">
<div class="row">
	<h1 class="text-center text-uppercase">Hot Products<br><img src="<?php echo theme_url();?>images/arr2.jpg" alt=""></h1>
    
    <div class="o-hid pro_h">
  <div class="hot_scroll">
    <div class="arrival_list">
    
    <ul>
   <?php
	foreach($hot_product as $val){
		
		$link_url = base_url().$val['friendly_url'];
		$discounted_price = $val[$mtype.'product_discounted_price']>0 && $val[$mtype.'product_discounted_price']!=null ? TRUE : FALSE;
		$prodImage=get_image('products',$val["media"],'290','378');
		if($val['product_alt'] !=""){
			$alt_tag=$val['product_alt'];
		}else{
			$alt_tag=$val['product_name'];
		}
		$cond="AND 	products_id = '".$val['products_id']."'";
		$stock_cnt=get_product_stock($cond);
		?>
    <li><div class="probox">
            <?php if($stock_cnt>0){?>
            
                <?php }else{?>
                <p class="abs"><img src="<?php echo theme_url();?>images/water-sold.png" alt=""></p>
                <?php }?>
                <div class="pro-title white">
                <p class="add-cart"><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><img src="<?php echo theme_url(); ?>images/add-cart.png" width="42" height="42" alt="<?php echo $alt_tag;?>"></a></p>
                <p><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><?php echo char_limiter($val['product_name'],55);?></a></p>
                </div>
                <p class="pro"><span><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><img src="<?php echo $prodImage;?>" alt="<?php echo $alt_tag;?>"></a></span></p>
                <p class="pro-price2">
                <span class="fs15 hidden-xs"><?php echo char_limiter($val['product_name'],30);?><br /></span>
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
            </div></li>
    <?php
	}?>
    </ul>
    <div class="clearfix"></div>
    </div>
    </div>  
   </div> 
    
   
    <div class="mt25 text-center"><a href="#" onclick="return search_form_submit('hot_product');" title="Browse More" class="btn-style2">Browse More</a></div>
</div> 
</div>
	<?php
}?>
<!--Hot Products end-->

<!--Featured Products-->
<?php
if( is_array($featured_product) && !empty($featured_product) ){?>
<div class="featured-bg minmax pb25">
<div class="container pt30">
<div class="row">
	<h2 class="text-center text-uppercase mb20">Featured Products<br><img src="<?php echo theme_url(); ?>images/arr3.png" alt="" class="mt5"></h2>
    
    
<div class="o-hid pro_h2">
<div class="fea_scroll">
<div class="featured_list">
<ul>
<?php
	foreach($featured_product as $val){
		
		$link_url = base_url().$val['friendly_url'];
		$discounted_price = $val[$mtype.'product_discounted_price']>0 && $val[$mtype.'product_discounted_price']!=null ? TRUE : FALSE;
		$prodImage=get_image('products',$val["media"],'185','241');
		if($val['product_alt'] !=""){
			$alt_tag=$val['product_alt'];
		}else{
			$alt_tag=$val['product_name'];
		}
		$cond="AND 	products_id = '".$val['products_id']."'";
		$stock_cnt=get_product_stock($cond);
		?>
<li><div class="probox-sml">
            <p class="add-cart2"><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><img src="<?php echo theme_url(); ?>images/add-cart.png"  alt="Add to Cart"></a></p>
            <div class="pro-sml"><span><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><img src="<?php echo $prodImage;?>" alt="<?php echo $alt_tag;?>"></a></span></div>
            <div class="prosml-grey">
            <p class="fs15 b lht-22" style="height:73px;"><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><?php echo char_limiter($val['product_name'],55);?></a></p>
            <p class="mt18 fs15 b lht-24">
            <?php 
                if($discounted_price===TRUE){?>
                        <del class="fs15" style="color:#656565;"><?php echo display_price($val[$mtype."product_price"]);?></del><br />
                        <?php echo  display_price($val[$mtype.'product_discounted_price']);?>
                <?php 
                }else{?>
                        <?php echo  display_price($val[$mtype.'product_price']);?>
                   <?php 
                }?>
                </p>
            </div>
            </div></li>
 <?php
	}?>   
    </ul>
<div class="clearfix"></div>
</div>
</div>
</div>   
    
    
<p class="mt40 text-center"><a href="#" onclick="return search_form_submit('featured_product');" title="Browse More" class="btn-style2">Browse More</a></p>
</div> 
</div>
</div>
	<?php
}?>
<!--Featured Products end-->

<!--Our Brand-->
<?php
if( is_array($brand_res) && !empty($brand_res) ){?>
<div class="container pt30">
<div class="row">
	<h1 class="text-center text-uppercase">our Brands<br><img src="<?php echo theme_url(); ?>images/arr2.jpg" alt="" width="16" height="9"></h1>
    
    <div class="o-hid" style="height:111px;">
     <?php
	foreach($brand_res as $val){
		
		$brandImage=get_image('brand',$val["brand_image"],'307','99');
		?>
         <div class="col-lg-3 col-md-4 col-sm-6 p10">
        	<p class="brand-pic"><span><a href="#" onclick="return search_form_submit2('product_brand','<?php echo $val['brand_name'];?>');" title="<?php echo $val['brand_name'];?>"><img src="<?php echo $brandImage;?>" alt="<?php echo $val['brand_name'];?>"></a></span></p>
        </div> 
       <?php
	}?>
    <p class="clearfix"></p>
    
    </div>
    
    <p class="mt20 text-center"><a href="<?php echo base_url();?>brand" title="Browse More" class="btn-style2">Browse More</a></p>
</div> 
</div>
	<?php
}?>
<!--Our Brand end-->

<?php $this->load->view("bottom_application");?>