<?php
$this->load->helper(array('products/product'));
if(is_array($res) && !empty($res)){
	$counter=0;
	foreach($res as $val){
		$link_url = base_url().$val['friendly_url'];
		$discounted_price = $val['product_discounted_price']>0 && $val['product_discounted_price']!=null ? TRUE : FALSE;
		$prodImage=get_image('products',$val["media"],'142','111');
		$alt_tag=$val['product_alt'];
		$cond="AND product_id='".$val['products_id']."'";
		//$stock_cnt=get_product_stock($cond);
		?>
        <li class="listpager">
          <div class="listi">
            <div class="listing">
              <figure><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><img src="<?php echo $prodImage;?>" alt="<?php echo $alt_tag;?>"></a></figure>
            </div>
            <p class="gray1 fs14 weight600 text-center mt20 h34 text-uppercase"><a href="<?php echo $link_url;?>" title="<?php echo $alt_tag;?>"><?php echo char_limiter($val['product_name'],15);?></a></p>
            <p class="fs13 ttu text-center h56 mt5">MODEL- <?php echo $val['product_code'];?><br>
              Price<br>
              <span class="black weight600"><?php echo display_price($val["product_price"]);?></span></p>
            <p class="clearfix"></p>
          </div>
          <div class="text-center">
              <p class="view-more-btn"><a href="<?php echo $link_url;?>" title="View Details">View More</a></p>
              <p class="add-more-btn"><a href="<?php echo base_url();?>cart/add_to_wishlist/<?php echo $val['products_id'];?>" title="Add to Favorite">Add to Favorite</a></p>
            </div>
        </li>       
		<?php
	}
}?>