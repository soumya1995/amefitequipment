<?php
if ( ! function_exists('you_save'))
{	
	function you_save($price,$discount_price)
	{  
		
		if($price!='' && $discount_price!='')
		{
			$you_save = ((($price-$discount_price)/$price)*100);
			return round($you_save, 2);		
		}
		
	}
}



function price_range(){
	$CI = CI();
	return  array(
					"0-50"=>"Below  ".$CI->config->item("currency_symbol")."50",
					"50-100"=>$CI->config->item("currency_symbol")."50 - ".$CI->config->item("currency_symbol")."100",
					"101-200"=>$CI->config->item("currency_symbol")." 101 - ".$CI->config->item("currency_symbol")." 200",
					"201-500"=>$CI->config->item("currency_symbol")." 201 - ".$CI->config->item("currency_symbol")." 500",
					"501"=>"Above ".$CI->config->item("currency_symbol")." 500 "					
				);	
}
	

if ( ! function_exists('rating_html'))
{
	function rating_html($rating,$max_rating,$img_arr=array())
	{
	  if(!is_array($img_arr))
	  {
		$img_arr = array();
	  }
	  if(!array_key_exists('glow',$img_arr))
	  {
		$img_arr['glow'] = '<img alt="" class="vam" src="'.theme_url().'images/str1.png">';
	  }
	  if(!array_key_exists('fade',$img_arr))
	  {
		$img_arr['fade'] = '<img alt="" class="vam" src="'.theme_url().'images/str2.png">';
	  }
	  $rating = ceil($rating);
	  $rating = $rating > $max_rating ? $max_rfating : $rating;
	  $var = "";
	  $nostar = $max_rating - $rating;
	  
	  for($jx=1;$jx<=$rating;$jx++)
	  {
		$var.=$img_arr['glow'];
	  }

	  for($jx=1;$jx<=$nostar;$jx++)
	  {
		$var.=$img_arr['fade'];
	  }

	  return $var;
	}
}

if ( ! function_exists('product_overall_rating'))
{
	function product_overall_rating($product_id,$entity_type)
	{
		$CI = CI();
		$res = $CI->db->query("SELECT AVG(rate) as rating FROM  wl_review WHERE prod_id ='".$product_id."' AND status ='1' AND rev_type='P' ")->row();
		return $res->rating;
	}
} 