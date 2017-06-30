<?php
$this->load->helper(array('products/product'));

if(is_array($res) && !empty($res)){
	$counter=0;
	$mtype=$this->mtype;
	foreach($res as $val){
		$link_url = base_url().$val['friendly_url'];
		$discounted_price = $val[$mtype.'product_discounted_price']>0 && $val[$mtype.'product_discounted_price']!=null ? TRUE : FALSE;
		$prodImage=get_image('products',$val["media"],'290','378');
		$alt_tag=$val['product_alt'];
		$cond="AND 	products_id = '".$val['products_id']."'";
		$stock_cnt=get_product_stock($cond);
		//if($stock_cnt > 0){
			/*if($_SERVER['REMOTE_ADDR']=="14.140.19.35")
			{
				trace($stock_cnt);
			}*/
		?>
        <div class="col-lg-3 col-md-4 col-sm-6 p10 listpager">
            <div class="probox ">
            <?php if($stock_cnt>0){?>
            
                <?php }else{?>
                <p class="abs"><img src="<?php echo theme_url();?>images/water-sold.png" alt=""></p>
                <?php }?>
                <div class="pro-title">
                <p class="add-cart"><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><img src="<?php echo theme_url(); ?>images/add-cart.png" alt="<?php echo $alt_tag;?>"></a></p>
                <p><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><?php echo char_limiter($val['product_name'],55);?></a></p>
                </div>
                <p class="pro"><span><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><img src="<?php echo $prodImage;?>" alt="<?php echo $alt_tag;?>"></a></span></p>
                <p class="pro-price2">
                <span class="fs15 hidden-xs"><?php echo char_limiter($val['product_name'],30);?><br /></span>
                <?php 
                if($discounted_price===TRUE){?>
                        <del class="fs13 "><?php echo display_price($val[$mtype."product_price"]);?></del>
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
	}
}
$cnt = count($res);
?>