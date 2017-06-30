<?php 
$this->load->view("top_application");
$this->load->model(array('weight/weight_model','prices/price_model'));

$thumbc['width']=3984;
$thumbc['image']=3984;
$thumbc['source_path']=UPLOAD_DIR.'/products/';	
//$discounted_price = $res['product_discounted_price']>0 && $res['product_discounted_price']!=null ? TRUE : FALSE;	
$service_type_arr=($this->config->item('service_type'));
$mtype=$this->mtype;
$productId = $res['products_id'];
?>
<script type="text/javascript" src="<?php echo resource_url();?>zoom/magiczoomplus.js"></script> 
<script type="text/javascript">function serialize_form() { return $('#myform').serialize();   } </script>
<div class="container pt10 minmax">
  <div class="row">
    <div class="inner-cont">    
       <h1 class="heading"><?php echo $res['product_name'];?></h1> 
       <?php echo category_breadcrumbs($res['category_id'],'',$res['product_name']); ?>
      <div class="mt40">
        <div class="col-lg-4 col-md-5 col-sm-12 p0">
          <div class="pro-thmb">
            <div>
              <ul class="thmb-pic">
              	<?php
				   $ix=0;
				   $thumbc['image']=TRUE;
				   foreach($media_res as $v){
					   $thumbc['org_image']=$v['media'];
					   Image_thumb($thumbc,'R');
					   $cache_file="thumb_".$thumbc['width']."_".$thumbc['height']."_".$thumbc['org_image'];
					   $catch_img_url=thumb_cache_url().$cache_file;
					   ?>
						<li>
							<p class="thmb"><span><a href="<?php echo img_url();?>products/<?php echo $v['media'];?>" rel="zoom-id:Zoomer" rev="<?php echo $catch_img_url;?>"><img src="<?php echo get_image('products',$v['media'],75,59,'R');?>"  alt="<?php echo $res['product_alt'];?>" ></a></span></p></li>   
					<?php
				}?>                
              </ul>
              <p class="clearfix"></p>
            </div>
          </div>
          <div class="pro-dtl" style="border:1px solid #ccc;padding:5px;"><span><a href="<?php echo img_url();?>products/<?php echo $res['media']?>" class="MagicZoomPlus" id="Zoomer" title="" rel="zoom-position:inner; thumb-change:mouseover"><img src="<?php echo get_image('products',$res['media'],285,371,'R');?>" class="db" alt=""></a></span></div>
          <p class="clearfix"></p>
        </div>
        
        <div class="col-lg-7 col-md-7 col-sm-12">
          <p class="fs24 black mt10"><?php echo $res['product_name'];?>  (<?php echo $res['product_code'];?>)</p>
          <?php if(!empty($res['product_coming_soon'])){?><p class="fs18 black"><strong>Duration:</strong> <?php echo $res['product_coming_soon'];?></p><?php } ?>
          <?php if(!empty($res['product_brand'])){?><p class="mt5"><strong>Brand:</strong> <?php echo $res['product_brand'];?></p><?php } ?>
          <?php if(!empty($res['product_color'])){?><p class="mt2 input-w-l"><strong>Color:</strong> <?php echo $res['product_color'];?></p><?php } ?>
          <?php if(!empty($res['product_size'])){?><p class="mt2 input-w-r"><strong>Size:</strong> <?php echo $res['product_size'];?></p><?php } ?>
          <p class="clearfix"></p>
          
          <?php if(!empty($res['product_weight'])){?><p class="mt2  input-w-l"><strong>Weight:</strong> <?php echo $res['product_weight'];?> <?php echo $this->config->item('weight_unit');?></p><?php } ?>
          <?php if(!empty($res['product_length'])){?><p class="mt2 input-w-r"><strong>Length:</strong> <?php echo $res['product_length'];?> <?php echo $this->config->item('length_unit');?></p><?php } ?>
          <?php if(!empty($res['product_width'])){?><p class="mt2 input-w-l"><strong>Width:</strong> <?php echo $res['product_width'];?> <?php echo $this->config->item('width_unit');?></p><?php } ?>
          <?php if(!empty($res['product_height'])){?><p class="mt2 input-w-r"><strong>Height:</strong> <?php echo $res['product_height'];?> <?php echo $this->config->item('width_unit');?></p><?php } ?>
          
          <div class="clearfix"></div>
          <?php 
		  echo form_open('cart/add_to_cart/'.$res['products_id'],array('name'=>'cartfrm','id'=>'cartfrm'));
		  if($res['is_coming_soon']=='0'){?> 
          <?php $services = custom_result_set("select service_id, price from tbl_product_services where product_id = '$productId' AND status ='1' ");
          if(!empty($service_type_arr) && !empty($services)){
          ?>
          <div class="service-box">
          <p class="mt10 input-w-r">
          <strong>Select Service</strong><br>
<p class="clearfix mt10"></p>
         <p class="mt10">
         	 <?php   
					foreach($services as $serviceVal){?>                    	
                                            <label class="ml10"><input name="service_type" id="service_type" data-price="<?php echo $serviceVal['price']?>" type="radio" value="<?php echo $serviceVal['service_id'];?>" class="mt5 " onclick="return add_price(this,'service');"> <?php echo $service_type_arr[$serviceVal['service_id']];?></label>                        
						<?php
					}
				
			?>
         </p>
        
<?php
	
			
			$wpram=array();
			$ppram=array();
			
			$wpram['product_id']	=	$res['products_id'];
			$wpram['type']	=	'W';			
			$wres=$this->product_model->get_product_attributes($wpram);
			$ppram['product_id']	=	$res['products_id'];
			$ppram['type']	=	'P';			
			$pres=$this->product_model->get_product_attributes($ppram);
				
			?> 
         <div class="service1 serv-cont form_box" >
             <div>                               
                 <?php
				 if(!empty($wres)){?>
                 <label> Warranty </label>  
                     <select name="warranty" id="warranty" onchange="return add_price(this,'warranty');">
                         <option value="">Select</option>
                         <?php
						 foreach($wres as $wval){
                                                    
							 ?>                         
                         	 <option data-price="<?php echo $wval['product_price'];?>" value="<?php echo $wval['type_id'];?>"><?php echo $wval['variant_name']." (".display_price($wval['product_price']);?>)</option>
                                <?php
						 }?>
                     </select>
                 	<?php
				 }?>
             <div class="clearfix"></div>
             </div>
         	 <div class="clearfix"></div>         
             <div class="mt5">                 
                  <?php
				 if(!empty($pres)){?>
                 <label>Packages</label>
                 <select name="package" id="package" onchange="return add_price(this,'package')">
                 	 <option value="">Select</option>
                     <?php
						 foreach($pres as $pval){							 
							 ?>
                     		<option data-price="<?php echo $pval['product_price'];?>" value="<?php echo $pval['type_id'];?>"><?php echo $pval['variant_name']." (".display_price($pval['product_price']);?>)</option>
                            <?php
						 }?>
                 </select>
                 	<?php
				 }?>
             <div class="clearfix"></div>
             </div>         
          	<div class="clearfix"></div>
          </div>       
         
          
          </p>
          <div class="clearfix"></div>
          </div>
          <?php
          }  }?>
          <p class="clearfix"></p>
          <p class="mt20 bb2"></p>
          <div class="col-lg-6 col-md-5 col-sm-5 br mt20 p0">            
            <?php if($res[$mtype.'product_discounted_price']!="0.00"){?>            
            	<p class="fs14 lht-22 grey">Offer Price : <del class="fs20"><?php echo display_price($res[$mtype."product_price"]);?></del> <span class="blue fs24 ml10" id="price1"><?php echo  display_price($res[$mtype.'product_discounted_price']);?> </span>
                
                </p>
            <?php 
			$product_price=$res[$mtype.'product_discounted_price'];
			}else{?>
            	<p class="fs14 lht-22 grey"  id="price2">Offer Price : <span class="blue fs24 ml10"><?php echo  display_price($res[$mtype.'product_price']);?></span></p>
            <?php 
			$product_price=$res[$mtype.'product_price'];
			}?>
            <p class="fs14 lht-22 grey"  id="price3" style="display:none;">Total Price : <span class="blue fs24 ml10"><?php echo $this->session->userdata('symbol_left');?></span><span class="blue fs24" id="price"><?php echo $product_price;?></span></p>
            <p class="mt10">  
            	<input type="hidden" name="warranty_id" id="warranty_id" value="" />
            	<input type="hidden" name="package_id" id="package_id" value="" />  
                <input type="hidden" name="warranty_type" id="warranty_type" value="" />
            	<input type="hidden" name="package_type" id="package_type" value="" />
                <input type="hidden" name="actual_price" id="actual_price" value="<?php echo $product_price;?>" />        
              	<input type="hidden" name="hidden1" id="hidden1" value="0" />
             	<input type="hidden" name="hidden2" id="hidden2" value="0" /> 
                <input type="hidden" name="hidden3" id="hidden3" value="0" />   
              	<input type="hidden" name="product_price" id="product_price" value="0" />
              
              <input name="action" type="submit" class="btn-style2 w70" value="Buy Now">
            </p>
            <p class="clearfix"></p>
          </div>
           <?php echo form_close();?>
          <div class="col-lg-6 col-md-7 col-sm-7 mt20 fs12">
            <p class="b black fs16"><?php if($res['review_count'] > 0){?><a href="#reviews" class="scroll"><?php echo $res['review_count'];?> REVIEWS</a><?php }else{?><?php echo $res['review_count'];?> REVIEWS<?php } ?></p>
        	<?php  if($this->session->userdata('user_id') > 0){?><p class="mt10 text-uppercase"><a href="#post" class="scroll"><img src="<?php echo theme_url(); ?>images/write.png" alt="" class="vam mr3"> Write a Review</a></p><?php } ?>
          </div>
          <p class="clearfix"></p>
          <p class="bb2 mt15"></p>
          <p class="mt15 ttu black lht-28"><a href="<?php echo base_url();?>cart/add_to_wishlist/<?php echo $res['products_id'];?>" class="mr20"><img src="<?php echo theme_url(); ?>images/wishlist.png" alt="" class="vam mr5" width="25"> Add to Favorites</a> <br class="mob_only"><a href="<?php echo base_url();?>pages/refer_to_friends" class="pop1 mr20"><img src="<?php echo theme_url(); ?>images/refer.png" alt="" class="vam mr5" width="25"> Refer to a Friend</a> <br class="mob_only"><a href="#" onclick="window.print() ;"><img src="<?php echo theme_url(); ?>images/print.png" alt="" class="vam mr5" width="25"> Print this Page</a></p>
          <p class="bb2 mt20"></p>
          <p class="mt20"><img src="<?php echo theme_url(); ?>images/blt-sign.png" alt="" class="vam"> Terms &amp; Conditions <span class="blue2 mr45"><a href="<?php echo base_url();?>terms-conditions" target="_blank">[?]</a></span> <br class="mob_only"><img src="<?php echo theme_url(); ?>images/blt-sign.png" alt="" class="vam"> Return Policy <span class="blue2 mr50"><a href="<?php echo base_url();?>return-policy" target="_blank">[?]</a></span></p>
          <p class="bb2 mt20"></p>
          <p class="mt15"><a href="https://www.facebook.com/AMEFitEquipment/" target="_blank" title="Facebook" class="mr5"><img src="<?php echo theme_url(); ?>images/fb.png" alt="Facebook"></a> <a href="https://twitter.com/amefitequipment" target="_blank" title="Twitter"><img src="<?php echo theme_url(); ?>images/tw.png" alt="Twitter"></a> <a href="https://www.instagram.com/amefitnessequipment/" target="_blank" title="Instagram"><img src="<?php echo theme_url(); ?>images/insta1.jpg" alt="Instagram"></a></p>
        </div>
        <p class="clearfix"></p>
      </div>
      <p class="mt20 bb"></p>
      <?php
	  if(!empty($res['products_description'])){?>
      <div class="mt30">
        <p class="fs18 b blue">Description</p>
        <div class="mt5 lht-18"><?php echo $res['products_description'];?></div>
      </div>
      <?php
	  }?>
      
      <?php
	  if(is_array($related_products) && !empty($related_products) ){?>
      <div class="mt30">
        <p class="fs18 b blue">Related Products</p>
        <div>
        <?php
		foreach($related_products as $val){
			$link_url = base_url().$val['friendly_url'];
			$discounted_price = $val[$mtype.'product_discounted_price']>0 && $val[$mtype.'product_discounted_price']!=null ? TRUE : FALSE;
			$prodImage=get_image('products',$val["media"],'290','378');
			$alt_tag=$val['product_alt'];
			$cond="AND product_id='".$val['products_id']."'";
			//$stock_cnt=get_product_stock($cond);
			//if($stock_cnt > 0){
			?>
        	<div class="col-lg-3 col-md-4 col-sm-6 p10">
              <div class="probox ">
                <div class="pro-title">
                <p class="add-cart"><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><img src="<?php echo theme_url(); ?>images/add-cart.png" alt="<?php echo $alt_tag;?>"></a></p>
                <p><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><?php echo char_limiter($val['product_name'],30);?></a></p>
                </div>
                <p class="pro"><span><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><img src="<?php echo $prodImage;?>" alt="<?php echo $alt_tag;?>"></a></span></p>
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
			//}
		}?>
            <p class="clearfix"></p>
         </div>
      </div>
     	<?php
	  }?>
      
      <a id="reviews"></a>
    
    <div class="mt30">
<?php
echo form_open('',array("name"=>"myform","id"=>"myform"));

if(is_array($review_res) && !empty($review_res)) { 
?>    
    <div id="my_data">
  	<?php  if($this->session->userdata('user_id') > 0){?><p class="fr mb20"><a href="#post" class="btn-style3 scroll">Post Your Comment</a></p><?php } ?>
    <p class="fs18 mb20 b blue">Recent Reviews</p>
    <p class="cb"></p>   
    
    <?php 
		foreach($review_res as $key=>$cval) {
	?>  
    	<div class="mb30">   
        <div class="col-xs-1 p0">
             <p class="fs11 mt5"><?php echo getDateFormat($cval['posted_date'],1);?></p>
        </div>
        <div class="col-xs-11">
        <p class="black b text-uppercase"><?php echo $cval['poster_name'];?> Says:</p>        
		<div class="lht-15"><?php echo $cval['comment'];?></div>
        </div>
        <p class="clearfix"></p>
		</div>        
        	<?php
		}?>
        <div class="text-center">
        <ul class="pager"><?php echo $page_links; ?></ul>        
        </div>
               
        <?php
	}
		 if($this->session->userdata('user_id') > 0){?>
        <a id="post"></a>
        <div class="cmnt-post input-field">
        <?php
		echo validation_message();
		echo error_message();
		?>
        <input type="hidden" name="mem_id" id="mem_id" value="<?php echo $this->session->userdata('user_id');?>" />
            <div class="input-field">    
            <p class="fs24 weight300 text-uppercase mb5 black">Write a Review</p>	
            <p class="reg-field input-w-l mt5"><input type="text" name="name" id="name" placeholder="Enter Your Name*" class="w98" value="<?php echo set_value('name');?>"></p>
            <p class="reg-field input-w-l mt5"><input type="text" name="email" id="email" placeholder="Enter Your Email Address*" value="<?php echo set_value('email');?>" class="w98"></p> 
            <p class="cb"></p>    
            <p class="mt5">
            <textarea name="comments" id="comments" rows="6" class="w99 opensans fs13" placeholder="Enter Your Comment*"><?php echo set_value('comments');?></textarea>
            </p>
            <p class="mt5">            
            <input type="text" name="verification_code" id="verification_code" placeholder="Word Verification *" style="width:150px;"><br class="mob_only"><img src="<?php echo site_url('captcha/normal'); ?>" class="vam p1" alt="" id="captchaimage"/> <a href="javascript:viod(0);" title="Change Verification Code"><img src="<?php echo theme_url(); ?>images/refresh-icon.png" class="vam ml10" alt="Refresh" onclick="document.getElementById('captchaimage').src='<?php echo site_url('captcha/normal');?>/<?php echo uniqid(time());?>'+Math.random(); document.getElementById('verification_code').focus();"></a>
            </p>
            <p class="mt10"><input name="button" type="submit" class="button-style fs18" value="Post" ></p>  
            <p class="cb"></p>	
            </div>
        
        </div> 
     </div>
      <?php 
	  }
	  echo form_close();?>
    </div>
      
    </div>
    
    </div>
</div></div></div>	  
<script>

function add_price(obj,type){
	type =$.trim(type);
        var control_name = $.trim($(obj).attr('name'));
        if(type=='service')
        {
            var service_price = $(obj).data('price');
        }
        else{
            var service_price = $(obj).find("option:selected").data("price");
            var value = $(obj).val();
            if(control_name=='warranty')
                {
                    $('#warranty_id').val(value);
                }
                else{
                     $('#package_id').val(value);
                }
            
        }
        service_price = (typeof(service_price) != "undefined")?service_price:'0';
        service_price = parseInt(service_price);
        switch(control_name)
        {
            case "service_type":
                $('#hidden3').val(service_price);
                 var price_to_add1 = parseInt($('#hidden1').val());
                     var price_to_add2 = parseInt($('#hidden2').val());
                break;
                 case "warranty":
                     $('#hidden1').val(service_price);
                      var price_to_add1 = parseInt($('#hidden3').val());
                      var price_to_add2 = parseInt($('#hidden2').val());
                break;
                 case "package":
                     $('#hidden2').val(service_price);
                     var price_to_add1 = parseInt($('#hidden1').val());
                     var price_to_add2 = parseInt($('#hidden3').val());
                break;
        }
       var ap = parseInt($('#actual_price').val());
       var price = ap + service_price + price_to_add1 + price_to_add2;
       $('#product_price').val(price);
       $('#price1').html(currency_symbol+'&nbsp;'+price+'.00');
	
}

</script>                                 
<?php $this->load->view("bottom_application");?>