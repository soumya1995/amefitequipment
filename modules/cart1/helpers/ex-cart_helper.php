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
			$subtotal = ( $val['quantity']*$val['product_price']);
			$total   += $subtotal;
			$unit_price=round($val['product_price']*(100/(100+$val['product_tax'])),2);
			$tax=$val['product_price']-$unit_price;
			$sub_total=$sub_total+($unit_price*$val['quantity']);
			$total_tax   += ($tax*$val['quantity']);
			$grand_total      = ($sub_total+$ordmaster['shipping_amount']);	
			$order_products.='			
			<tr>
			<td align="center" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;">'.$i.'.</td>
			<td width="11%" align="left" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;"><img src="'.base_url().'cart/display_cart_image/'.$val['orders_products_id'].'" alt="" width="90" height="58" style="margin-right:10px; border:1px solid #ccc; padding:5px"></td>
			<td width="69%" align="left" valign="top" style="border-bottom:1px solid #ddd; padding-bottom:10px;"><p style="color:#333; font-size:13px; padding-top:5px; margin:0px; line-height:18px"> <strong style="font-size:16px">'.$val['product_name'].'</strong> <span style="font-size:12px; display:block; padding-top:2px; font-family: Arial, Helvetica, sans-serif">
			
			
	<b>Product Code</b> :'.$val['product_code'].'/ <strong>Weight</strong> : '.$val['product_weight'].'/ <b>Quantity :</b> '.$val['quantity'].'
	<br>
	Price: '.display_price($unit_price).' </p></td>
	<td align="center" valign="top" style="width:10%; border-bottom:1px solid #ddd; padding-bottom:10px;"><strong>'.display_price($grand_total).'</strong></td>
		  </tr>
		  <tr align="center">
			<td colspan="4" valign="top" ><img src="'.theme_url().'images/spacer.gif" width="1" height="1" alt=""></td>
		  </tr>
			';
			
			$i++;
		}
	}
	
	$grand_total      = ($sub_total+$ordmaster['shipping_amount']);	
	?>
	<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1">
      <tr>
        <td align="left"><p style="padding-top:2px; margin:0px; color:#333; line-height:18px;"><strong><?php $ci=CI(); echo $ci->config->item('site_name');?></strong><br>
            <?php echo $admin_address;?><br>
            <span style=" padding-top:3px;">Email Us : <a href="mailto:<?php echo $site_details['admin_email'];?>" style="color:#000; font-weight:bold;"><?php echo $site_details['admin_email'];?></a></span> Phone : <?php echo $site_details['phone'];?> </p>
        <br></td>
        <td align="right" valign="middle" style="padding-right:10px;"><img src="<?php echo theme_url(); ?>images/invo-logo.png" alt="" width="245" height="79"></td>
      </tr>
    </table>
    <br>
  <div style="width:44%; border:1px solid #CCC; padding:15px; height:180px; overflow:hidden; float:left">
      <div style="font:bold 16px/20px Arial, Helvetica, sans-serif; color:#333; border-bottom:1px solid #ccc; margin-bottom:10px">Order Summary</div>
      <div style="margin-top:5px; font:normal 12px/20px Arial, Helvetica, sans-serif"><b>Invoice No. : <?php echo $ordmaster['invoice_number'];?></b> (Dated : <?php echo getDateFormat($ordmaster['order_received_date'],1);?>)</div>
      <div style="margin-top:10px; font:normal 12px/20px Arial, Helvetica, sans-serif">Subtotal Amount : <strong><?php echo display_price($sub_total);?><br>
      <span class="font:bold 10px/30px Arial, Helvetica, sans-serif; color:#000"><?php if($ordmaster['shipping_method']!="FREE"){?>Shipping Charge [<?php echo ucwords($ordmaster['shipping_method']);?>] : <?php echo display_price($ordmaster['shipping_amount']);?><br><?php } ?></span>
        <b style="font:bold 16px/30px Arial, Helvetica, sans-serif; color:#000">Total Payable Amount : <strong><?php echo display_price($grand_total);?></b></div>
    </div>
  <div style="width:44%; border:1px solid #CCC; padding:15px; height:180px; overflow:hidden; float:right;">
      <div style="font:bold 16px/20px Arial, Helvetica, sans-serif; color:#333; border-bottom:1px solid #ccc; margin-bottom:10px">Delivery Information</div>
      <div style="margin-top:5px; font:normal 12px/20px Arial, Helvetica, sans-serif"><b><?php echo $ordmaster['shipping_name'];?></b><br>
    Mobile :  <?php echo $ordmaster['shipping_mobile'];?><br>
Email : <?php echo $ordmaster['email'];?></div>
      <div style="margin-top:10px; font:normal 12px/20px Arial, Helvetica, sans-serif"><?php echo $ordmaster['shipping_address'];?>, <?php echo $ordmaster['shipping_city'];?>, <?php echo $ordmaster['shipping_state'];?> - <?php echo $ordmaster['shipping_zipcode'];?>, <?php echo strtoupper($ordmaster['shipping_country']);?></div>
    </div>
    <div style="clear:both"></div>
    <br>
  <div style="font:bold 22px/20px 'Trebuchet MS', Arial, Helvetica, sans-serif; color:#000; margin-top:10px">Product Details</div>
    <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" style="margin-top:10px;">
      <tr style="font-size:13px; color:#fff; line-height:36px; background:#777777">
        <td width="10%" align="center" style="line-height:20px; width:10%"><strong>S.No</strong></td>
        <td align="left" colspan="2"><strong>Products</strong></td>
        <td width="10%" align="center" style="width:10%"><strong>Amount</strong></td>
      </tr>
      <tr align="center">
        <td colspan="4" valign="top" ><img src="<?php echo theme_url(); ?>images/spacer.gif" width="1" height="1" alt=""></td>
      </tr>
      <?php echo $order_products;?> 
      
    </table>
  <a href="#" onclick="window.print();" style="color:#f00; text-decoration:none; float:left; font:bold 13px/22px 'Trebuchet MS', Arial, Helvetica, sans-serif; text-transform:uppercase; margin:0px 10px 0 0"><img src="<?php echo theme_url(); ?>images/prnt.png" border="0" style="float:left; margin-right:3px" alt=""> Print Invoice</a>
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
	if(is_array($orddetail)	 && !empty($orddetail) ){
		foreach ($orddetail as $val){
			$shipping_charge = !empty($val['shipping_charge'])?$val['shipping_charge']:0;
			$subtotal = ( $val['quantity']*$val['product_price']);
			$total   += $subtotal;
			$unit_price=round($val['product_price']*(100/(100+$val['product_tax'])),2);
			$tax=$val['product_price']-$unit_price;
			$sub_total=$sub_total+($unit_price*$val['quantity']);
			$total_tax   += ($tax*$val['quantity']);
			$order_products.='
			<div class="mylsttb row">
			  <div class="col-xs-12 hidden-xs col-sm-1">'.$i.'.</div>
			  <div class="col-xs-12 col-sm-7"><strong class="visible-xs mb5">Product Details : </strong>
				<p class="fs18 black b"><b class="fl thm1 mr10 mb10"><img src="'.base_url().'cart/display_cart_image/'.$val['orders_products_id'].'" alt="" width="100" height="100"></b>'.$val['product_name'].'</p>
				<p class="mt5 fs12">Product Code : '.$val['product_code'].'</p>
				<p class=" fs12">Weight : '.$val['product_weight'].'</p>
				<p class="black fs16 mt2">Price: <span class="red b">'.display_price($unit_price).'</span></p>
				<div class="clearfix"></div>
			  </div>
			  <div class="col-xs-12 col-sm-2 ac"><strong class="visible-xs-inline">Quantity : </strong> <b class="fs16">'.$val['quantity'].'</b> </div>
			  <div class="col-xs-12 col-sm-2 ac">
				<p class="b black fs18"><strong class="visible-xs-inline fs14">Amount : </strong> '.display_price($subtotal).'</p>
			  </div>
			  <div class="cb"></div>
			</div>';
			$i++;
		}
	}		
	
	$grand_total      = ($sub_total+$ordmaster['shipping_amount']);	
	?>	
	<div class="row mt15">
    <div class="pull-right text-right col-sm-3"> <img src="<?php echo theme_url(); ?>images/invo-logo.png" alt="" width="245" height="79" class="mw_100"></div>
    <div class="col-sm-6">
      <p><b class="fs18 db mb5"><?php $ci=CI(); echo $ci->config->item('site_name');?> </b> <?php echo nl2br($admin_address);?><br>
        <span class="pt3">Email Us : <b class="black"><a href="<?php echo $site_details['admin_email'];?>"><?php echo $site_details['admin_email'];?></a></b></span> Phone : <?php echo $site_details['phone'];?> </p>
    </div>
    <div class="clearfix pb20"></div>
    <div class="col-sm-6" >
      <div class="inv_box3">
        <div class="b fs16 lht-20 bb1 pb5 mb10">Order Summary</div>
        <div class="mt5 lht-20 fs12"><b>Invoice No. : <?php echo $invoice_number;?></b><br>
          Dated : <?php echo getDateFormat($ordmaster['order_received_date'],1);?></div>
        <div class="mt10 fs14 lht-20">Subtotal Amount : <?php echo display_price($sub_total);?><br>
        <?php if($ordmaster['shipping_method']!="FREE"){?>Shipping Charge [<?php echo ucwords($ordmaster['shipping_method']);?>] : <?php echo display_price($ordmaster['shipping_amount']);?><br><?php } ?>
          <b class="fs16 lht-30 pale">Total Payable Amount : <?php echo display_price($grand_total);?></b></div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="inv_box3">
        <div class="b fs16 lht-20 bb1 pb5 mb10">Delivery Information</div>
        <div class="mt5 lht-20 fs14"><b class="fs16"> <?php echo $ordmaster['shipping_name'];?></b><br>
          Mobile : <?php echo $ordmaster['shipping_mobile'];?><br>
Email : <?php echo $ordmaster['email'];?></div>
        <div class="mt10 fs12 lht-20"><b>Address</b><br>
          <?php echo $ordmaster['shipping_address'];?>, <?php echo $ordmaster['shipping_city'];?> - <?php echo $ordmaster['shipping_zipcode'];?>,<br><?php echo $ordmaster['shipping_country'];?>.</div>
      </div>
    </div>
    <div class="cb"></div>
  </div>
  
  <h3 class="mt20 b pb5">Product Details</h3>
  <div class="p10 pt15 pb15 bg-gray border1 hidden-xs fs14 ttu mt10 b">
    <div class="col-xs-12 col-sm-1">Sn.</div>
    <div class="col-xs-12 col-sm-7">Products</div>
    <div class="col-xs-12 col-sm-2 ac">Quantity</div>
    <div class="col-xs-12 col-sm-2 ac">Amount</div>
    <div class="clearfix"></div>
  </div>
  <div>
    <?php echo $order_products;?>    
    <div class="mb30"></div>
  </div>
  <div class="cb bb3"></div>
  <p class="red hidden-xs hidden-sm ac"> <a href="<?php echo base_url();?>cart/print_invoice/<?php echo $ordmaster['order_id'];?>" class="invoice1 fs16 radius-20b" style="padding:0 30px"> <b class="glyphicon glyphicon-print"></b> Print Invoice</a></p>
    <!-- left ends -->
    <div class="col-xs-12 visible-xs visible-sm">
      <div class="bb1 mb30 mt30"></div>
    </div>
	<?php
}