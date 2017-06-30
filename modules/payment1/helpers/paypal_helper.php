<?php
function paypalForm($order_res)
{
	
	define('PAYPAL_SANDBOX',false);	
	$CI =& get_instance();
	$amount    = ( ($order_res['total_amount']) + ( $order_res['shipping_amount']) + ( $order_res['vat_amount']) - ( $order_res['coupon_discount_amount']) );
	$orderid   = $order_res['order_id'];	
	$order_no  = $order_res['invoice_number'];

	
	
	if (PAYPAL_SANDBOX) $paypalWeb = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; // TEST SANDBOX
	
	else $paypalWeb = 'https://www.paypal.com/cgi-bin/webscr'; 
	
	?>
<body style="margin:0px;">    
    <div style="text-align:left; font-size: 22px; font-weight:bold;  background-color:#f9f9f9; border:#efefef; padding:20px;">
		<?php echo $CI->config->item('site_name');?>
    </div>
        <table style="width: 100%;">
            <tr>
                <td width="100%" align="center">
                    <div style="font-family: Arial; font-size: 16px; text-align: center; margin-top: 170px; background-color:#f9f9f9; border:#efefef; padding:20px; font-weight:bold; width:500px;"> 
                    <?php echo "We are just transfering you to the Paypal in few seconds"; ?><br />  <br />
                     <div style="width: 200px; margin-left:180px; text-align: left;  font-family: Arial; font-size: 22px; color:#090;">
                        Please wait <span id="loading_please_wait"></span>
                     </div> 
                    </div> 
                   

                </td>
           </tr>
           <tr>     
                <td width="100%" align="center">
                </td>
            </tr>
        </table>
        <?php echo form_open($paypalWeb,'name="form1"');?>
		<!--<form name="form1" action="<?php echo $paypalWeb;?>" method="post"> -->
		<input type="hidden" name="cmd" value="_xclick"> 
		<input type="hidden" name="cbt" value="Return To <?php echo $CI->config->item('site_name');?>"> 
		<input type="hidden" name="business" value="Sejalgulati01@gmail.com"> 
		<input type="hidden" name="item_name" value="<?php echo "Pay to purchase  in ".$CI->config->item('site_name'); ?>"> 
		<input type="hidden" name="item_number" value="<?php echo $order_no; ?>"> 
        
		<input type="hidden" name="amount" value="<?php echo $amount; ?>">
         
		<input type="hidden" name="return" value="<?php echo base_url(); ?>payment/order_success/paypal/<?php echo md5($orderid);?>"> 
        <input type="hidden" name="cancel_return" value="<?php echo base_url(); ?>payment/order_cancle/paypal/<?php echo md5($orderid);?>"/>
		<input type="hidden" name="no_note" value="1"> 		
        <input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="rm" value="2"> 
		</form> 	       
		<script type="text/javascript">
		
		form1.submit();
		
		i=-1;
		intvalid=setInterval(function(){append_dot('loading_please_wait',i++);},100);
		
		function append_dot(span_id,i)
		{
			span=document.getElementById(span_id);
			dots="";
			for(j=0;j<=i;j++)
			{
				dots+=".";
			}
			span.innerHTML=dots;
			num_dots=(span.innerHTML).length;
			if(parseInt(num_dots)>=8)
			{
				clearInterval(intvalid);
				i=-1;
				intvalid=setInterval(function(){append_dot('loading_please_wait',i++);},100);
			}
		}
        </script>
	<?php 
	
	die();
  }

?>