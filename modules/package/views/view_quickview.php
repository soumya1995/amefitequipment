<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Welcome</title>
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<link href="<?php echo base_url(); ?>assets/developers/css/proj.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo theme_url();?>css/avin.css">
<link rel="stylesheet" href="<?php echo theme_url();?>css/conditional_avin.css">
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css" media="screen">
@import url("<?php echo resource_url();?>fancybox/jquery.fancybox.css?v=2.1.5");

@import url("<?php echo theme_url();?>css/font-awesome.css");
</style>
</head>
<body style="padding:0">
<div class="p10 pt5 pb5">
  <h1 class="bb">Quick View Product</h1>
 <div class="row mt15" >
  
  <div class=" pull-left col-xs-4"> <div class="pro_dtl2"><figure><img src="<?php echo get_image('products',$res['media'],500,500,'R');?>" class="img-responsive" alt=""></figure></div></div>
  <div class=" pull-right col-xs-6 p0">
   <h1><?php echo $res['product_name'];?></h1>
    
    <div class="mt15">
    <p>Procut Code : <?php echo $res['product_code'];?></p>
    <p class="mt15"> <span class="black">Weight: <?php echo $weight_name;?>.</p>
      <div class="clearfix cb mb20"></div>
    </div>
    <div class="mb10 p10"><?php echo $res['products_description'];?></div>
    <p class="fs24 mt25 mb15" id="show_hide_price">Price: 
          <?php
            if($res["product_discounted_price"] > 0){?>			
                <del class="gray"> 
                <?php echo display_price($res["product_price"]);?></del> 
                <b class="red ml4"><?php echo display_price($res["product_discounted_price"]);?></b>			
            <?php
            }else{?>			                          
                <b class="red ml4"><?php echo display_price($res["product_price"]);?></b>			
            <?php
	  }?>
	</p>
    <a href="<?php echo base_url();?>cart/add_to_cart/<?php echo $res['products_id'];?>" target="_parent" class="btn1 atc_btn exo trans_eff vam" title="Add to Cart Now!">Add to Cart Now!</a>
    
    <a href="<?php echo base_url().$res['friendly_url'];?>" target="_parent" class="btn1 atc_btn exo trans_eff vam" title="View Details">View Details</a>
   
   <?php if($this->session->userdata('username')!=""){?> 
   <!--<input name="button" type="button" class="btn2 atc_btn trans_eff vam ml10" value="Add to Wishlist!" style="cursor:pointer" onclick="window.location.href=('<?php echo base_url();?>cart/add_to_wishlist/<?php echo $val['products_id'];?>')">-->
    <a href="<?php echo base_url();?>cart/add_to_wishlist/<?php echo $res['products_id'];?>" class="btn1 atc_btn exo trans_eff vam mystar mystarx ml10 vam" title="Add to Favorite" target="_parent">Add to Wishlist!</a> 
   <?php
   }?>
    </div>
  <div class="clearfix cb mb20"></div>
</div> </div>
</body>


</html>