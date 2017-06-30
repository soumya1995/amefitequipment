<?php
function getHash($details){
	ksort($details);
	$str = '';
	foreach ($details as $k => $v) {
		if ($k != 'hash' && isset($v)) 	$str .= "$v|";
	}
	//$str .= "fc41b31e7db4768f87dac04a5dac43219968817f55930048e7779b30f34e7788"; // Your secret key goes here. 
	$str .= "c0a36ccd3b30ecef42199a55d2d125b51b6d24bb17f267ba8b050aa91f9c54a9";
	return md5($str);
}
function PayZippylForm($order_res)
{
	
	$CI =& get_instance();
	$amount    = ( ($order_res['total_amount']) + ( $order_res['shipping_amount']) + ( $order_res['vat_amount']) - ( $order_res['coupon_discount_amount']) );
	$orderid   = $order_res['order_id'];	
	$order_no  = $order_res['invoice_number'];	
	?>
<body style="margin:0px;">    
    <div style="text-align:left; font-size: 22px; font-weight:bold;  background-color:#f9f9f9; border:#efefef; padding:20px;">
		<?php echo $CI->config->item('site_name');?>
    </div>
        <table style="width: 100%;">
            <tr>
                <td width="100%" align="center">
                    <div style="font-family: Arial; font-size: 16px; text-align: center; margin-top: 170px; background-color:#f9f9f9; border:#efefef; padding:20px; font-weight:bold; width:500px;"> 
                    <?php echo "We are just transfering you to the PayZippy in few seconds"; ?><br />  <br />
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
		<?php
        $request_url = "https://www.payzippy.com/payment/api/charging/v1"; //Charging Url
        $details_array = array();
        //$details_array['merchant_id'] = "test_t565"; //Your MID issued by PayZippy.
        $details_array['merchant_id'] = "ANGELSBASKET"; //Your MID issued by PayZippy.
        $details_array['buyer_email_address'] = $order_res['email']; // Email Address
        $details_array['merchant_transaction_id'] = $orderid; //Your Transaction Id
        $details_array['transaction_type'] = "SALE"; //This is the default Value.
        $details_array['transaction_amount'] = round($amount*100); //Amount must be in paise. So, 1 Rupee= 100.
        //$details_array['payment_method'] = "CREDIT"; // CREDIT,DEBIT,EMI,NET
        $details_array['payment_method'] = "payzippy"; // CREDIT,DEBIT,EMI,NET
        $details_array['bank_name'] = ""; //Bank Name required in case of EMI/NET.
        $details_array['emi_months'] = "0"; // Emi Months in case of EMI.
        $details_array['currency'] = "INR"; //INR is default.
        $details_array['ui_mode'] = "REDIRECT"; //REDIRECT/IFRAME.
        $details_array['hash_method'] = "MD5"; //MD5, SHA256
        $details_array['merchant_key_id'] = "payment"; //This is the default value.
        //$details_array['timegmt']= round(microtime(true) * 1000);
        $details_array['callback_url']="http://angelsbasket.com/payment/responce/".md5($orderid);
        $details_array['hash'] = getHash($details_array);        
        
        $request_url_to_be_hit  = $request_url."?".http_build_query($details_array);
        //print_r($request_url_to_be_hit); //This url printed needs to be redirected or put in iframe as the case may be.
        /*
            For integration using RIDIRECT mode, create a new HTML form, with hidden elements.
            Set its "action" attribute to $charging_object["url"].
            Create hidden input elements for every key, value pair in $charging_object["params"].
        */
        ?>
        <form method="POST" action="<?php echo $request_url;?>" id="payzippyForm">
            <?php
            foreach($details_array as $key => $value) {
                echo "<input type='hidden' name='{$key}' value='$value'>";
            }					
            ?>
        </form>
        </div>	       
		<script type="text/javascript">
		
		payzippyForm.submit();
		
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