<?php $page=$this->uri->segment(2);
$bill_info = $this->mres_address[0];
$ship_info = $this->mres_address[1];
//trace($mres);
/*Billing Address */
/*$bill_info_arr = array();
if($bill_info['address']!=''){
	array_push($bill_info_arr, ucwords($bill_info['address']));
}
if($bill_info['city']!=''){
	$billing_city=ucwords($bill_info['city']);
	if($bill_info['zipcode']!=''){
		$billing_city.=" - ".$bill_info['zipcode'];
	}
  array_push($bill_info_arr, $billing_city);
}
if($bill_info['state']!=''){
  array_push($bill_info_arr, ucwords($bill_info['state']));
}
if($bill_info['country']!=''){
  array_push($bill_info_arr,$bill_info['country']);
}
if(empty($bill_info_arr)){
  $bill_address = " - ";
}else{
	$bill_address = implode(", ",$bill_info_arr);
}
//Shipping Address
$ship_info_arr = array();
if($ship_info['address']!=''){
	array_push($ship_info_arr, ucwords($ship_info['address']));
}
if($ship_info['city']!=''){
	$shiping_city=ucwords($ship_info['city']);
	if($ship_info['zipcode']!=''){
		$shiping_city.=" - ".$ship_info['zipcode'];
	}
  array_push($ship_info_arr, $shiping_city);
}
if($ship_info['state']!=''){
  array_push($ship_info_arr, ucwords($ship_info['state']));
}
if($ship_info['country']!=''){
  array_push($ship_info_arr,$ship_info['country']);
}
if(empty($ship_info_arr)){
  $ship_address = " - ";
}else{
	$ship_address = implode(", ",$ship_info_arr);
}*/?>
<p class="p5 fs11"><b class="fs12"><?php echo ucwords($mres['first_name']." ".$mres['last_name']);?></b><br> (Last Login : <?php echo getDateFormat($mres['last_login_date'],9);?>)</p>
<p class="mb5 b fs11 red"><a href="<?php echo base_url();?>users/logout">(Log Out)</a></p>