<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('CI')){

	function CI()
	{
		if (!function_exists('get_instance')) return FALSE;
		$CI =& get_instance();
		return $CI;
	}
}


function order_invoice_content ($ordmaster,$orddetail,$print="")
{
	$curr_symbol = display_symbol();
	$site_details=get_db_single_row('tbl_admin','*',' and  admin_id =1');
	$cod_amount=$ordmaster['cod_amount'];
	$pstatus=$ordmaster['payment_status']=='Paid'?'Payment Received':'Payment Pending';
	$invoice_number=$ordmaster['invoice_number'];

	/*$bill_info = '<strong class="dorng">'.$ordmaster['billing_name'].'</strong><br>'.
	$ordmaster['billing_address'].',<br />'.
	$ordmaster['billing_city'].', '.
	$ordmaster['billing_state'].' - '.$ordmaster['billing_zipcode'].'<br />'.
	$ordmaster['billing_country'].'
	<br /><strong>Phone : '.$ordmaster['billing_phone'].'</strong>';

	$ship_info = '<strong class="dorng">'.$ordmaster['shipping_name'].'</strong><br>'.
	$ordmaster['shipping_address'].',<br />'.
	$ordmaster['shipping_city'].', '.
	$ordmaster['shipping_state'].' - '.$ordmaster['shipping_zipcode'].'<br />'.
	$ordmaster['shipping_country'].'
	<br /><strong>Phone : '.$ordmaster['shipping_phone'].'</strong>';*/

	if($site_details['address']) {
		$admin_address=	$site_details['address'].', <br>';
	}
	if($site_details['city']) {
		$admin_address.=	$site_details['city'].', ';
	}
	if($site_details['state']) {
		$admin_address.=	$site_details['state'];
	}
	if($site_details['zipcode']) {
		$admin_address.=	'-'.$site_details['zipcode'];
	}
	if($site_details['country']) {
		$admin_address.=	' <strong>'.strtoupper($site_details['country']).'</strong>';
	}
	
	$i=1;
	$subtotal ='';
	$total='';
	$total_tax=0;
	$sub_total=0;
	$shipping_charge=0;
	$total_shiping=0;
	$order_products='';
	if(is_array($orddetail)	 && !empty($orddetail) ){
		foreach ($orddetail as $val){
			$shipping_charge = !empty($val['shipping_charge'])?$val['shipping_charge']:0;
			$subtotal = ( $val['quantity']*($val['product_price']+$val['warranty_price']+$val['package_price']+$val['service_price']));
			$sub_total += $subtotal;
			$total   += $subtotal;	
			$order_products.='			
			<div style="padding:12px; border-bottom:#ddd 1px dashed; background:#fff; color:#000000;">
				<div style="float:left; width:10%;">'.$i.'.</div>
					<div style="float:left; width:65%;">
					  <div style="width:70%; float:right;">
						<div style="color:#000000; font-size:12px;">'.$val['product_name'].' ('.$val['product_code'].')  '.$val['service_name'].'</div>						
						';
						if(!empty($val['product_brand'])){ $order_products.='<div style="margin-top:5px;"><strong>Brand:</strong> '.$val['product_brand'].'</div>'; } 
						if(!empty($val['product_color'])){$order_products.='<div style="margin-top:5px;"><strong>Color:</strong> '.$val['product_color'].'</div>'; } 
						if(!empty($val['product_size'])){$order_products.='<div style="margin-top:5px;"><strong>Size:</strong> '.$val['product_size'].'</div>'; } 
						
						if(!empty($val['warranty_name'])){$order_products.='<div style="margin-top:5px;"><strong>Warranty:</strong> '.$val['warranty_name'].'</div>'; }
						if(!empty($val['package_name'])){$order_products.='<div style="margin-top:5px;"><strong>Package:</strong> '.$val['package_name'].'</div>'; } 
							
						$order_products.='
						<div style="margin-top:5px;">Qty.: '.$val['quantity'].'</div>	
						<div style="margin-top:5px; color:#ed1c24; font-size:15px;">Price: '.display_price($val['product_price']).'</div>
					  </div>
					<img src="'.base_url().'cart/display_cart_image/'.$val['orders_products_id'].'" alt=""> </div>
					<div style="float:left; width:24%; color:#000000; text-transform:uppercase; font-size:14px;">'.display_price($subtotal).'</div>
					<div style="clear:both;"></div>
			</div>
			';			
			
			$i++;
		}
	}
	
	$tax  = ($ordmaster['vat_amount'] > 0) ?  $ordmaster['vat_amount'] : '0';
  	$total_tax = ($sub_total*$tax/100);
	$grand_total      = ($sub_total+$total_tax+$ordmaster['shipping_amount']);		
	?>
<div style="border:#ddd 1px solid; padding:15px;">

        <div style="padding-bottom:10px; border-bottom:#eee 1px solid;">
        <div style="font-size:40px; text-align:center; padding-bottom:20px; border-bottom:#eee 1px solid; margin-top:15px;">INVOICE</div>
        <div style="float:left; width:48%; margin-top:10px;"><img src="<?php echo theme_url(); ?>images/ame.png" alt="" width="130"></div>
        <div style="float:right; width:48%; margin-top:10px;">
        <div><strong><?php $ci=CI(); echo $ci->config->item('site_name');?></strong><br>
            <?php echo $admin_address;?></div>
        <div style="margin-top:3px;">Email Us : <a href="mailto:<?php echo $site_details['admin_email'];?>" style="color:#000; font-weight:bold;"><?php echo $site_details['admin_email'];?></a></div>
        </div>
        <div style="clear:both;"></div>
        </div>
        
            
           <div style="padding:10px;">
            <div style="font-size:14px; line-height:28px; float:left; width:48%;"><strong>Order No. :</strong> <?php echo $ordmaster['invoice_number'];?><br> <strong>Invoice Date :</strong> <?php echo getDateFormat($ordmaster['order_received_date'],1);?></div>
            <div style="float:right; width:48%;">
            <div><strong>Delivery Information :</strong>   <br>
            <?php echo $ordmaster['shipping_name'];?> <br>Phone : <?php echo $ordmaster['shipping_phone'];?> <br>Mobile : <?php echo $ordmaster['shipping_mobile'];?><br><?php echo $ordmaster['shipping_address'];?>, <?php echo $ordmaster['shipping_city'];?> , <?php echo $ordmaster['shipping_state'];?>, <?php echo $ordmaster['shipping_country'];?> - <?php echo $ordmaster['shipping_zipcode'];?>.</div>
            </div>
            <div style="clear:both;"></div>
            </div>
        
        <div>
          <div style="background:#d3f0fb; color:#000; font-weight:bold; padding:12px; font-size:14px;">
              <div style="float:left; width:10%;">S.No.</div>
              <div style="float:left; width:65%;">Product Details</div>
              <div style="float:left; width:25%;">Sub Total</div>
            <div style="clear:both;"></div>
              </div>
              
           <?php echo $order_products;?> 
          
          
          <div style="text-align:center; margin-top:20px; font:14px 'Trebuchet MS', Arial, Helvetica, sans-serif; text-transform:uppercase;">Sub Total : <?php echo display_price($sub_total);?></div>
          <div style="text-align:center; margin-top:5px; font:14px 'Trebuchet MS', Arial, Helvetica, sans-serif; text-transform:uppercase;">Tax : <?php echo display_price($total_tax);?></div>
          
          <div style="text-align:center; margin-top:10px; font:16px 'Trebuchet MS', Arial, Helvetica, sans-serif; text-transform:uppercase; color:#000; font-weight:bold;">Amount Payable: <?php echo display_price($grand_total);?></div>
          
          <div style="margin:15px 0 0 0; text-align:center;"><a href="#" style="color:#000; width:150px; text-decoration:none;" onclick="window.print() ;"><img src="<?php echo theme_url(); ?>images/print-icon.png" alt="" style="vertical-align:middle;"> Print Order</a></div>
          
        </div>

</div>
	<?php
}


function order_invoice_content_thanks ($ordmaster,$orddetail)
{
	$curr_symbol = display_symbol();
	$site_details=get_db_single_row('tbl_admin','*',' and  admin_id =1');
	$cod_amount=$ordmaster['cod_amount'];
	$pstatus=$ordmaster['payment_status']=='Paid'?'Payment Received':'Payment Pending';
	$invoice_number=$ordmaster['invoice_number'];
	if($site_details['address']) {
		$admin_address=	$site_details['address'].', ';
	}
	if($site_details['city']) {
		$admin_address.=	$site_details['city'].', ';
	}
	if($site_details['state']) {
		$admin_address.=	$site_details['state'];
	}
	if($site_details['zipcode']) {
		$admin_address.=	'-'.$site_details['zipcode'];
	}
	if($site_details['country']) {
		$admin_address.=	' <strong>'.$site_details['country'].'</strong>';
	}
	
	$i=1;
	$subtotal ='';
	$total='';
	$total_tax=0;
	$sub_total=0;
	$shipping_charge=0;
	$total_shiping=0;
	$order_products='';
	//trace($orddetail);
	if(is_array($orddetail)	 && !empty($orddetail) ){
		foreach ($orddetail as $val){
			$shipping_charge = !empty($val['shipping_charge'])?$val['shipping_charge']:0;
			$subtotal = ( $val['quantity']*($val['product_price']+$val['warranty_price']+$val['package_price']+$val['service_price']));
			$sub_total += $subtotal;
			$total   += $subtotal;			
			$order_products.='
			<div class="p10 bb2 black">
				<div class="row fs13">
				<div class="col-xs-12 col-sm-1 hidden-xs">'.$i.'.</div>
				<div class="col-xs-12 col-sm-8">
					<div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 p0">
					<p class="thmb"><span><img src="'.base_url().'cart/display_cart_image/'.$val['orders_products_id'].'" alt=""></span></p>
					</div>
					<div class="col-lg-10 col-md-10 col-sm-9 col-xs-12 p0">
					<p class="black fs14">'.$val['product_name'].' ('.$val['product_code'].') / '.$val['service_name'].'</p>
					';
					if(!empty($val['product_brand'])){ $order_products.='<p class="mt5"><strong>Brand:</strong> '.$val['product_brand'].'</p>'; } 
					if(!empty($val['product_color'])){$order_products.='<p class="mt2"><strong>Color:</strong> '.$val['product_color'].'</p>'; } 
					if(!empty($val['product_size'])){$order_products.='<p class="mt3"><strong>Size:</strong> '.$val['product_size'].'</p>'; } 
					
					if(!empty($val['warranty_name'])){$order_products.='<p class="mt3"><strong>Warranty:</strong> '.$val['warranty_name'].'</p>'; }
					if(!empty($val['package_name'])){$order_products.='<p class="mt3"><strong>Package:</strong> '.$val['package_name'].'</p>'; } 
						
					$order_products.='<p>Qty.: '.$val['quantity'].'</p>
					<p class="red">Price: '.display_price($val['product_price']).'</p>	    
					</div>
					<p class="clearfix"></p>
				</div>
				<div class="col-xs-12 col-sm-3 black ttu fs14">'.display_price($subtotal).'</div>
				<p class="clearfix"></p>
				</div>
			</div>';
			$i++;
		}
	}		
	$tax  = ($ordmaster['vat_amount'] > 0) ?  $ordmaster['vat_amount'] : '0';
  	$total_tax = ($sub_total*$tax/100);
	$grand_total      = ($sub_total+$total_tax+$ordmaster['shipping_amount']);	
	?>	
	<div class="invoice-box">
    <div style="font-size:40px; text-align:center; padding-bottom:20px; border-bottom:#eee 1px solid;">INVOICE</div>
    <div style="padding-bottom:10px; border-bottom:#eee 1px solid; margin-top:15px;">
<div class="input-w-l"><img src="<?php echo theme_url(); ?>images/ame.png" alt="" width="130"></div>
<div class="input-w-r">
<div><?php $ci=CI(); echo $ci->config->item('site_name');?> </b> <?php echo nl2br($admin_address);?></div>
<div style="margin-top:3px;">Email Us : <a href="<?php echo $site_details['admin_email'];?>"><?php echo $site_details['admin_email'];?></a></div>
</div>
<div style="clear:both;"></div>
</div>

	
	<div style="padding:10px;">
	<div class="input-w-l" style="font-size:14px; line-height:28px;"><strong>Order No. :</strong> <?php echo $invoice_number;?><br> <strong>Invoice Date :</strong> <?php echo getDateFormat($ordmaster['order_received_date'],1);?></div>
	<div class="input-w-r">
	<div><strong>Delivery Information :</strong>   <br>
	<?php echo $ordmaster['shipping_name'];?> <br>Phone : <?php echo $ordmaster['shipping_phone'];?> <br>Mobile : <?php echo $ordmaster['shipping_mobile'];?><br><?php echo $ordmaster['shipping_address'];?>, <?php echo $ordmaster['shipping_city'];?> , <?php echo $ordmaster['shipping_state'];?>, <?php echo $ordmaster['shipping_country'];?> - <?php echo $ordmaster['shipping_zipcode'];?>.</div>
	</div>
	<div style="clear:both;"></div>
	</div>
	
<div class="mt10">

	  <div class="p10 bb hidden-xs b ttu black fs14" style="background:#d3f0fb;">
	  <div class="row">
	  <div class="col-xs-12 col-sm-1"> S.No. </div>
	  <div class="col-xs-12 col-sm-8"> Product Details </div>
	  <div class="col-xs-12 col-sm-3"> Sub Total </div>
	  <p class="clearfix"></p>
	  </div>
	  </div>      
      <?php echo $order_products;?>    
    </div>    
    
    <div style="text-align:center; margin-top:20px; font:14px 'Trebuchet MS', Arial, Helvetica, sans-serif; text-transform:uppercase;">Sub Total : <?php echo display_price($sub_total);?></div>
    <div style="text-align:center; margin-top:5px; font:14px 'Trebuchet MS', Arial, Helvetica, sans-serif; text-transform:uppercase;">Tax : <?php echo display_price($total_tax);?></div>
    
  <div style="text-align:center; margin-top:5px; font:bold 15px 'Trebuchet MS', Arial, Helvetica, sans-serif; text-transform:uppercase; color:#000;">Amount Payable: <?php echo display_price($grand_total);?></div>
  
  <div class="mob_hider" style="margin:15px 0 0 0; padding-top:15px; border-top:#ddd 1px solid; text-align:center; font-size:13px;"><a href="<?php echo base_url();?>cart/print_invoice/<?php echo $ordmaster['order_id'];?>" style="color:#000; width:150px; text-decoration:none;" class="print-invoice"><img src="<?php echo theme_url(); ?>images/print-icon.png" alt="" class="vam"> Print Order</a></div>
	      
    </div>	<?php
}