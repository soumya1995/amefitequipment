<?php
function DirectPostForm($order_res)
{
	//trace($order_res);
	//exit;
	$CI =& get_instance();
	$amount    = ( ($order_res['total_amount']) + ( $order_res['shipping_amount']) + ( $order_res['vat_amount']) - ( $order_res['coupon_discount_amount']) );
	$orderid   = $order_res['order_id'];	
	$order_no  = $order_res['invoice_number'];	
	
	// Insert your security key ID here
	$gw_merchantKeyId = '5686888';
	// Insert your security key here
	$gw_merchantKeyText = 's8P763ns8r2qW9jXz4ac9hn363U3f8Tr';


function gw_printField($name, $value = "", $gw_merchantKeyText = 's8P763ns8r2qW9jXz4ac9hn363U3f8Tr') {
   
    static $fields;
    // Generate the hash
    if($name == "hash") {
        $stringToHash = implode('|', array_values($fields)) .
            "|" . $gw_merchantKeyText;
        $value = implode("|", array_keys($fields)) . "|" . md5($stringToHash);
    } else {
        $fields[$name] = $value;
    }
    print "<input type=\"hidden\" name=\"$name\" value=\"$value\">\n";
}
?>
<form name="dForm" id="dForm" method="post" action="https://secure.networkmerchants.com/cart/cart.php">
<input type="hidden" name="customer_receipt" value="false">
<input type="hidden" name="key_id" value="<?=$gw_merchantKeyId?>">
<input type="hidden" name="url_finish" value="https://www.amefitequipment.com/payment/responce/">
<?php
    // Print the description, SKU, shipping, and amount using the gw_printField
    // function. Don't call the gw_printField function for fields that you
    // wish to omit (ie. shipping)
?>
<?php gw_printField("action", "process_fixed"); ?>
<?php gw_printField("order_description", ""); ?>
<?php gw_printField("shipping", ""); ?>
<?php gw_printField("amount", $order_res['total_amount']); ?> 
<?php gw_printField("orderid", $orderid); ?> 
 
<?php gw_printField("first_name", $order_res['first_name']); ?>
<?php gw_printField("last_name", $order_res['last_name']); ?>
<?php gw_printField("company", "AME Fitness Equipment"); ?>
<?php gw_printField("country", $order_res['shipping_country']); ?>
<?php gw_printField("address_1", $order_res['shipping_address']); ?>
<?php gw_printField("address_2", ""); ?>
<?php gw_printField("city", $order_res['shipping_city']); ?>
<?php gw_printField("state", $order_res['shipping_state']); ?>
<?php gw_printField("postal_code", $order_res['shipping_zipcode']); ?>
<?php gw_printField("phone", $order_res['shipping_phone']); ?>
<?php gw_printField("fax", $order_res['shipping_fax']); ?>
<?php gw_printField("email", $order_res['email']); ?>
<?php gw_printField("url", "https://www.amefitequipment.com/"); ?>
<?php
    // Once all product information fields are printed, print the hash field
    // There is no need to specify a value when printing the hash field.
?>
<?php gw_printField("hash"); ?>
</form>
<script type="text/javascript">		
	dForm.submit();
</script>
<?php
	die();
  }

?>