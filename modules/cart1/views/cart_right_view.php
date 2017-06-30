<?php $curr_symbol = display_symbol();
if($this->cart->total_items() > 0){
$this->load->model('cart/cart_model');

$user_id=$this->session->userdata('user_id')>0?$this->session->userdata('user_id'):$this->session->userdata('guest');

$i=1;
$shipping_total = 0;
$shipping_weight = 0;
$total_tax=0;
$sub_total=0;
foreach($this->cart->contents() as $items){
	$link_url=base_url().$items['friendly_url'];				
	$amount=(($items['price']+$items['options']['warranty_price']+$items['options']['package_price']+$items['options']['service_price'])*$items['qty']);
	$sub_total+=$amount;
	$mt=($i=='1')?"":"mt5";	
	
	if(!empty($items['options']['service_type']) && !empty($items['options']['warranty_id'])){

		$woption["where"] = array('product_id'=>$items['pid'],'type_id'=>$items['options']['warranty_id'],'type'=>'W');
		$wres=$this->warranty_model->get_product_base_price($woption);
		$warranty_name = $wres['variant_name'];
		$available_quantity = $wres['quantity'];					
	}
	if(!empty($items['options']['service_type']) && !empty($items['options']['package_id'])){

		$poption["where"] = array('product_id'=>$items['pid'],'type_id'=>$items['options']['package_id'],'type'=>'P');
		$pres=$this->warranty_model->get_product_base_price($poption);
		$package_name = $pres['variant_name'];
		$available_quantity = $pres['quantity'];					
	}	    
?>        
        <div class="mt10">
          <div class="bdr mb5 p10 radius-3 bgW">
            <p class="blue fs14">
            <a href="<?php echo base_url(); ?>cart/remove_item/<?php echo $items['rowid']; ?>" onclick="return confirm('Are you sure you want to remove this item?');"><img src="<?php echo theme_url(); ?>images/delete.png" class="fr" alt=""></a> 
            <a href="<?php echo $link_url;?>"><?php echo $items['origname'];?> (<?php echo $items['code'];?>) / <?php echo $items['options']['service_name'];?></a></p>
            
            <?php if(!empty($items['brand'])){?><p class="mt5"><strong>Brand:</strong> <?php echo $items['brand'];?></p><?php } ?>
			<?php if(!empty($items['color'])){?><p class="mt2"><strong>Color:</strong> <?php echo $items['color'];?></p><?php } ?>
            <?php if(!empty($items['size'])){?><p class="mt3"><strong>Size:</strong> <?php echo $items['size'];?></p><?php } ?>
            
            <?php if(!empty($items['options']['warranty_id'])){?><p class="mt3"><strong>Warranty:</strong> <?php echo $warranty_name;?></p><?php } ?>
            <?php if(!empty($items['options']['package_id'])){?><p class="mt3"><strong>Package:</strong> <?php echo $package_name;?></p><?php } ?>
                
            <p>Qty.: <?php echo $items['qty'];?></p>
            <?php 
				if($items['discount_price']!="0.00"){?>            
            	<p class="mt5">Price:  <del class=" "><?php echo display_price($items['product_price']);?></del> <span class=" blue"><?php echo  display_price($items['discount_price']);?></span></p>
                
                </p>
				<?php
                }else{?>
                    <p class="mt5">Price: <span class=" blue"><?php echo  display_price($items['product_price']);?></span></p>
                <?php 
                }?>
                <p>Sub Total: <?php echo display_price($amount);?></p>
            <div class="cb"></div>
          </div>
        </div>
	<?php
}
  /*$cart_total      = $this->cart->total();  	    
  $grand_total      = $cart_total+$total_shipping_charge;
  $this->session->set_userdata('total_amount_payable',$grand_total);*/
  $tax  = ($this->admin_info->tax > 0) ?  $this->admin_info->tax : '0';
  $total_tax = ($sub_total*$tax/100);
  $this->session->set_userdata('total_amount_payable',$sub_total);		
 ?>     
   <div class="text-right mt15">
    <p>Sub Total: <?php echo display_price($sub_total);?></p>
    <p class="mt5">Tax (<?php echo display_price($this->admin_info->tax);?> % ): <?php echo display_price($total_tax);?></p>
    <p class="red fs15 mt5">Amount Payable: <?php echo display_price($this->session->userdata('total_amount_payable')+$total_tax);?></p>
   </div>        
	<?php
}?>