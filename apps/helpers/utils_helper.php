<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
* The global CI helpers 


*/

if ( ! function_exists('CI'))
{
	function CI()
	{
		if (!function_exists('get_instance')) return FALSE;
		
		$CI = &get_instance();		
		return $CI;
	}
}

if ( ! function_exists('getDateFormat')){	

	function getDateFormat($date,$format,$seperator1=",")
	{
		$arr_time1=explode(" ",$date);
		$arr_date=strtotime($date);
		switch($format)
		{
			case 1: // (Ymd)->(dmY) 06 Dec, 2010 
				$ret_date=date("d M".$seperator1." Y",$arr_date);           
			break;
		
			case 2: // (Ymd)->(dmY) 06 December, 2010
				$ret_date=date("d F".$seperator1." Y",$arr_date);           
			break;
			
			case 3: // (Ymd)->(dmY) Mon Dec 06, 2010 
				$ret_date=date("D M d".$seperator1." Y",$arr_date);           
			break;
			
			case 4: // (Ymd)->(dmY) Monday December 06, 2010 
				$ret_date=date("l F d".$seperator1." Y",$arr_date);           
			break;
			
			case 5: // (Ymd)->(dmY) Thursday April 17, 1975, 03:04:00 
				$ret_date=date("l F d".$seperator1." Y".$seperator1." h:i:s",$arr_date);           
			break;
			
			case 6: // (Ymd)->(dmY) Thursday April 17, 1975, 8:28 AM 
				$ret_date=date("l F d".$seperator1." Y".$seperator1." H:i A",$arr_date);           
			break;
			
			case 7: // (Ymd)->(dmY) Apr 17, 1975, 8:28 PM 
				$ret_date=date("d M".$seperator1." Y".$seperator1." H:i A",$arr_date);           
			break;
			
			case 8: // (Ymd)->(dmY) Apr 17, 1975, 03:04 
				$ret_date=date("d M".$seperator1." Y".$seperator1." h:i",$arr_date);           
			break;
			
			case 9: // (Ymd)->(mdY) Apr 17, 1975 [Thursday] 				
				$ret_date=date("M d".$seperator1." Y [l]",$arr_date);           
			break;
			
			case 10: // (Ymd)->(mY) April 1975
				$ret_date=date("F Y",$arr_date);           
			break;
			
			case 11: // (Ymd)->(d) 25
				$ret_date=date("d",$arr_date);           
			break;
			
		}
		return $ret_date;
	}
}


if ( ! function_exists('humanTiming'))
{	
	function humanTiming($time)
	{
		$CI = CI();
		$p="";
		$currtent_time = strtotime($CI->config->item('date_time_format'));
		
		$diff = (int) abs( $currtent_time - $time); 
		
		$tokens = array(
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);
		foreach ($tokens as $unit => $text) {
			if ($diff < $unit) continue;
			$numberOfUnits = round($diff / $unit);
			return $p= $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}
		return ($p=='' ? '1 seconds' : $p);
		
	}
}


/************************************************************
1.Convert Nested Array to Single Array
2.If $key is not empty then key will be preserved but 
value will be overwrite if occur more than once

************************************************************/

if ( ! function_exists('array_flatten'))
{
	function array_flatten($array,$return,$key='')
	{
		if(is_array($array))
		{
			foreach($array as $ky=>$val)
			{
				$key=($key!=='' ? $ky : '');
				
				$return = array_flatten($val,$return,$key);
			}
		}else
		{
			if($key!='')
			{
				$return[$key]=$array;
			}else
			{
				$return[]=$array;
			}
		}
		return $return;
	} 
}

/*
find one array 
$arr1 =  array('0'=>'1','1'=>'2')
$arr2 =  = array('1' =>'Boarding Job','2' =>'Night Job','3'=>'Daily Job');
$result ==> Boarding Job,Night Job
*/ 
function getArrayValueBykey($arr1,$arr2)
{
    $res =array();
	if( is_array($arr1) && is_array($arr2) ){
		
		foreach($arr1 as $key=>$val){
			
		  if($val!="" )
		  {
			  
		    $res[] = $arr2[$val];
			
		   }
		  		
		}		
	
	}
	
  return $res;
}


if ( ! function_exists('getAge'))
{
	function getAge($dob)
	{
		$age = 31536000;  //days secon 86400X365
		$birth = strtotime($dob); // Start as time
		$current = strtotime(date('Y')); // End as time
		if($current > $birth)
		{
			$finalAge = round(($current - $birth) /$age)+1;
		}
		return $finalAge;
	}
}


//$in_string = " hi  this dkmphp  net india  wenlink india  development fun company php delhi";
//$spam_word_arr = array('php','net','fun');

if ( ! function_exists('check_spam_words'))
{
	function check_spam_words($spam_word_arr,$in_string)
	{
		$is_spam_found = false;
		if( is_array($spam_word_arr) && $in_string!="" )
		{ 
			foreach($spam_word_arr as $val)
			{   
				if( preg_match("/\b$val\b/i",$in_string) )
				{
					$is_spam_found = true;
					break;
				}
			}
		}
		return $is_spam_found;
	}
}

if ( ! function_exists('file_ext'))
{
	function file_ext($file)
	{
		$file_ext = strtolower(strrchr($file,'.'));
		$file_ext = substr($file_ext,1);
		return $file_ext;
	}
}


if ( ! function_exists('applyFilter'))
{
	function applyFilter($type,$val)
	{
		switch($type)
		{
			case 'NUMERIC_GT_ZERO':
				$val=preg_replace("~^0*~","",trim($val));
				return preg_match("~^[1-9][0-9]*$~i",$val) ? $val : 0;
			break;
			case 'NUMERIC_WT_ZERO':
				return preg_match("~^[0-9]*$~i",trim($val)) ? $val : -1;
			break;
		}
	}
}

if( ! function_exists('removeImage'))
{
	function removeImage($cfgs)
	{	
		if($cfgs['source_dir']!='' && $cfgs['source_file']!='')
		{
			$pathImage=UPLOAD_DIR."/".$cfgs['source_dir']."/".$cfgs['source_file'];
			if(file_exists($pathImage))
			{
				unlink($pathImage);
			}
		}
	}	
}


if( ! function_exists('trace'))
{
	function trace()
	{
		list($callee) = debug_backtrace();
		$arguments = func_get_args();
		$total_arguments = count($arguments);

		echo '<fieldset style="background: #fefefe !important; border:3px red solid; padding:5px; font-family:Courier New,Courier, monospace;font-size:12px">';
	    echo '<legend style="background:lightgrey; padding:6px;">'.$callee['file'].' @ line: '.$callee['line'].'</legend><pre>';
	    $i = 0;
	    foreach ($arguments as $argument)
	    {
			echo '<br/><strong>Debug #'.(++$i).' of '.$total_arguments.'</strong>: ';

			if ( (is_array($argument) || is_object($argument)) && count($argument))
			{
				print_r($argument);
			}
			else
			{
				var_dump($argument);
			}
		}

		echo '</pre>' . PHP_EOL;
		echo '</fieldset>' . PHP_EOL;
	
	}
}

if( ! function_exists('find_paging_segment'))
{ 
	 function find_paging_segment($debug=FALSE)
	 {
		 $ci=  CI();
		 $segment_array = $ci->uri->segments;
		 
		 if($debug)
		 {
		   trace($ci->uri->segments);
		 }
		 
		 $key =  array_search('pg',$segment_array);
		
		return $key+1;
		 
	 } 
}



if ( ! function_exists('make_missing_folder'))
{
	function make_missing_folder($dir_to_create="")
	{
		if(empty($dir_to_create))
		return;
			
		$dir_path=UPLOAD_DIR;
		$subdirs=explode("/",$dir_to_create);
		foreach($subdirs as $dir)
		{
		  if($dir!="")
		  {
			  $dir_path = $dir_path."/".$dir;	
			  if(!file_exists($dir_path) )
			  {
					//echo $dir_path;
					mkdir($dir_path,0755);
			  }else
			  {
				   chmod($dir_path,0755);
			  }
			  
		  }
		}
	}
}

if ( ! function_exists('char_limiter'))
{
  function char_limiter($str,$len,$suffix='...')
  {
	  $str = strip_tags($str);
	  if(strlen($str)>$len)
	  {
		  $str=substr($str,0,$len).$suffix;
	  }
	  return $str;
  }
}  

if ( ! function_exists('redirect_top'))
{
	function redirect_top($url='')
	{
			if(!strpos($url,'ttp://') && !strpos($url,'ttps://'))
			$url=base_url().$url;
			
			if($url==''):
			?>
			<script>
			 top.$.fancybox.close();
			 window.top.location.reload();
			</script>
			<?php
			else:
			
			?>
			<script>
			 top.$.fancybox.close();
			 window.top.location.href="<?php echo $url?>";
			</script>
			<?php
			endif;
			exit;
	}
}

if ( ! function_exists('confirm_js_box'))
{	
	function confirm_js_box($txt='remove')
	{
		
		$var = "onclick=\"return confirm('Are you sure you want to $txt this record');\" ";
	    return $var;	
	}
}



/*
    A)  $varg contains  following options 
		
    default_text 	=>      Default Option Text
	name 		    => 		Dropdn name
	id 		        => 		Dropdn id (default to name)
	format      	=>	    All extra attributes for the dpdn(style,class,event...)
	opt_val_fld     =>      i).$result is from database => field name to be shown in option value box
							ii).$result is custom single dimensional array => key/value for option value box(default 'key')								
	opt_txt_fld     =>      i).$result is from database => field name to be shown in option text box
							ii).$result is custom single dimensional array => key/value for option text box(default 'value')
	B) $result         =>     result set  from database or could be your single dimensional associative/index array
	
	*/

if ( ! function_exists('make_select_box'))
{	
	function make_select_box($varg=array(),$result=array())
	{	
	
		$ci = CI();	
		$var="";
				
		$varg['default_text']=!array_key_exists('default_text',$varg) ? "Select" : $varg['default_text'];
		
		$varg['id']=!array_key_exists('id',$varg) ? $varg['name'] : $varg['id'];
		
		$opt_val_fld = !array_key_exists('opt_val_fld',$varg) ? $varg['opt_val_fld'] : 'key';
		
		$opt_txt_fld = !array_key_exists('opt_txt_fld',$varg) ? $varg['opt_txt_fld'] : 'value';
		
		$is_associative_array = !array_key_exists('associative',$varg) ? FALSE : $varg['associative'];
		
		
		$var.='<select name="'.$varg['name'].'" id="'.$varg['id'].'" '.$varg['format'].'>';
		
		if($varg['default_text']!="")
		{
			$var.='<option value="" selected="selected">'.$varg['default_text'].'</option>';
		}		
		
		foreach($result as $key=>$val)
		{	
		   	if( is_array($val) && !empty($val))
			{ 
				if(is_array($varg['current_selected_val']))
				{					
					$select_element=in_array($val[$opt_val_fld],$varg['current_selected_val']) ? "selected" : "";
					
				}else
				{					
					$select_element=( $varg['current_selected_val']==$val[$opt_val_fld] ) ? "selected" : "";
					
				}	
						
				$var.='<option value="'.$val[$opt_val_fld].'" '.$select_element.'>'.ucfirst($val[$opt_txt_fld]).'</option>';
				   
			}else
			{		
						
				$opt_val_fld = $opt_val_fld === 'key' ? $key : $val;
				$opt_txt_fld = $opt_txt_fld === 'key' ? $key : $val;
				
				if(is_array($varg['current_selected_val']))
				{					
					$select_element=in_array($opt_val_fld,$varg['current_selected_val']) ? "selected" : "";
					
				}else
				{					
					$select_element=( $varg['current_selected_val']==$opt_val_fld ) ? "selected" : "";
					
				}	
						
				$var.='<option value="'.$opt_val_fld.'" '.$select_element.'>'.$opt_txt_fld.'</option>';					
				
			}
			
			
		}
		
		$var.='</select>';
		
		return $var;
	}

}


function CountrySelectBox($varg=array())
{	
	$CI = CI();	
	$var="";
	
	/**********************************************************
	default_text 		=>Default Option Text
	name 		=> 			Dropdn name
	id 		=> 			Dropdn id (default to name)
	format      		=>	all extra attributes for the dpdn(style,class,event...)
	opt_val_fld     =>      DpDn option value field to be fetched from database
	opt_txt_fld     =>      DpDn option text field to be fetched from database
	
	***********************************************************/		
	$varg['default_text']=!array_key_exists('default_text',$varg) ? "Select Country" : $varg['default_text'];
	$varg['id']=!array_key_exists('id',$varg) ? $varg['name'] : $varg['id'];
	$opt_val_fld=!array_key_exists('opt_val_fld',$varg) ? "name" : $varg['opt_val_fld'];
	$opt_txt_fld=!array_key_exists('opt_txt_fld',$varg) ? "name" : $varg['opt_txt_fld']; 
	
	$var.='<select name="'.$varg['name'].'" id="'.$varg['id'].'" '.$varg['format'].'>';
	if($varg['default_text']!="")
	{
		$var.='<option value="" selected="selected">'.$varg['default_text'].'</option>';
	}	
	$contry_res=$CI->db->query("SELECT * FROM wl_countries WHERE 1")->result_array();
	foreach($contry_res as $key=>$val)
	{		
		if(is_array($varg['current_selected_val']))
		{
			$select_element=in_array($val[$opt_val_fld],$varg['current_selected_val']) ? "selected" : "";
		}else
		{
			$select_element=( $varg['current_selected_val']==$val[$opt_val_fld] ) ? "selected" : "";
		}		
		$var.='<option value="'.$val[$opt_val_fld].'" '.$select_element.'>'.ucfirst($val[$opt_txt_fld]).'</option>';
	}
	$var.='</select>';
	return $var;
}

if ( ! function_exists('get_content')){
	
	function get_content($tbl="wl_auto_respond_mails",$pageId)
	{
		$CI = CI();	
		
		if( $pageId > 0 )
		{ 
			$res =  $CI->db->get_where($tbl,array('id'=>$pageId))->row();

			if( is_object($res) )
			{
				return $res;
			}
		}
	}
}

if ( ! function_exists('get_product_shipping_charges')){
	
	function get_product_shipping_charges($pid){
		$CI = CI();		
		if( $pid > 0 ){ 
			$res =  $CI->db->get_where("wl_products",array('products_id'=>$pid))->row();
			if( is_object($res)){				
				return $res->shipping_charges;
			}
		}
	}
}

if ( ! function_exists('get_weight_attr')){ //12,16,5....
	
	function get_weight_attr($product_id){
		  $CI = CI();					
		  if($product_id!="") {		
			$res =  $CI->db->query("SELECT attribute_id, product_id, weight_id, SUM(quantity) as qty, product_price, product_discounted_price FROM wl_product_attributes WHERE product_id='$product_id' AND status='1' GROUP BY product_id ")->row_array();
					
			if( is_array($res)){				
				return $res;
			}
		}		
	}
}

if ( ! function_exists('get_minimum_product_price')){ //12,16,5....
	
	function get_minimum_product_price($product_id){
		  $CI = CI();					
		  if($product_id!="") {		
			$res =  $CI->db->query("SELECT attribute_id, product_id, weight_id, product_price, product_discounted_price FROM wl_product_attributes WHERE product_id='$product_id' AND status='1' ORDER BY product_price ASC limit 1 ")->row_array();
					
			if( is_array($res)){				
				return $res;
			}
		}
		
		
	}
}

if ( ! function_exists('get_products_weight')){ //12,16,5....
	
	function get_products_weight($product_id){
		  $CI = CI();					
		  if($product_id!="") {		
			$res =  $CI->db->query("SELECT weight_id, variant_name FROM wl_product_attributes WHERE product_id='$product_id' AND status='1' ORDER BY variant_name ASC ")->result_array();			
			
			if( is_array($res)){				
				return $res;
			}
		}		
	}
}

function WeightSelectBox($varg=array())
{	
/*trace($varg);
exit;*/
	$CI = CI();	
	$var="";
	
	/**********************************************************
	default_text 		=>Default Option Text
	name 		=> 			Dropdn name
	id 		=> 			Dropdn id (default to name)
	format      		=>	all extra attributes for the dpdn(style,class,event...)
	opt_val_fld     =>      DpDn option value field to be fetched from database
	opt_txt_fld     =>      DpDn option text field to be fetched from database
	
	***********************************************************/		
	$varg['default_text']=!array_key_exists('default_text',$varg) ? "Select Weight" : $varg['default_text'];
	$varg['id']=!array_key_exists('id',$varg) ? $varg['weight_name'] : $varg['id'];
	$opt_val_fld=!array_key_exists('opt_val_fld',$varg) ? "weight_name" : $varg['opt_val_fld'];
	$opt_txt_fld=!array_key_exists('opt_txt_fld',$varg) ? "weight_name" : $varg['opt_txt_fld']; 
	
	$var.='<select name="'.$varg['name'].'" id="'.$varg['id'].'" '.$varg['format'].'>';
	if($varg['default_text']!="")
	{
		$var.='<option value="" selected="selected">'.$varg['default_text'].'</option>';
	}	
	$weight_res=$CI->db->query("SELECT * FROM wl_weights WHERE status='1' ORDER BY weight_name ASC")->result_array();
	foreach($weight_res as $key=>$val)
	{		
		if(is_array($varg['current_selected_val']))
		{
			$select_element=in_array($val[$opt_val_fld],$varg['current_selected_val']) ? "selected" : "";
		}else
		{
			$select_element=( $varg['current_selected_val']==$val[$opt_val_fld] ) ? "selected" : "";
		}		
		$var.='<option value="'.$val[$opt_val_fld].'" '.$select_element.'>'.ucfirst($val[$opt_txt_fld]).'</option>';
	}
	$var.='</select>';
	return $var;
}


function CountryIdSelectBox($varg=array())
{	
	$CI = CI();	
	$var="";
	
	/**********************************************************
	default_text 		=>Default Option Text
	name 		=> 			Dropdn name
	id 		=> 			Dropdn id (default to name)
	format      		=>	all extra attributes for the dpdn(style,class,event...)
	opt_val_fld     =>      DpDn option value field to be fetched from database
	opt_txt_fld     =>      DpDn option text field to be fetched from database
	
	***********************************************************/		
	$varg['default_text']=!array_key_exists('default_text',$varg) ? "Select Country" : $varg['default_text'];
	$varg['id']=!array_key_exists('id',$varg) ? $varg['name'] : $varg['id'];
	$opt_val_fld=!array_key_exists('opt_val_fld',$varg) ? "country_id" : $varg['opt_val_fld'];
	$opt_txt_fld=!array_key_exists('opt_txt_fld',$varg) ? "name" : $varg['opt_txt_fld']; 
	
	$var.='<select name="'.$varg['name'].'" id="'.$varg['id'].'" '.$varg['format'].'>';
	if($varg['default_text']!="")
	{
		$var.='<option value="" selected="selected">'.$varg['default_text'].'</option>';
	}	
	$contry_res=$CI->db->query("SELECT * FROM wl_countries WHERE status!='2' ORDER BY (country_id='184') DESC, name ASC")->result_array();
	foreach($contry_res as $key=>$val)
	{		
		if(is_array($varg['current_selected_val']))
		{
			$select_element=in_array($val[$opt_val_fld],$varg['current_selected_val']) ? "selected" : "";
		}else
		{
			$select_element=( $varg['current_selected_val']==$val[$opt_val_fld] ) ? "selected" : "";
			if(is_string($varg['current_selected_val'])){
				$select_element=( $varg['current_selected_val']==$val[$opt_txt_fld] ) ? "selected" : "";
			}
		}		
		$var.='<option value="'.$val[$opt_val_fld].'" '.$select_element.'>'.ucfirst($val[$opt_txt_fld]).'</option>';
	}
	$var.='</select>';
	return $var;
}

function StateSelectBox($varg=array()) 
{	
	$CI = CI();	
	$var="";
	
	/**********************************************************
	default_text 		=>Default Option Text
	name 		=> 			Dropdn name
	id 		=> 			Dropdn id (default to name)
	format      		=>	all extra attributes for the dpdn(style,class,event...)
	opt_val_fld     =>      DpDn option value field to be fetched from database
	opt_txt_fld     =>      DpDn option text field to be fetched from database
	
	***********************************************************/		
	$varg['default_text']=!array_key_exists('default_text',$varg) ? "Select State" : $varg['default_text'];
	$varg['id']=!array_key_exists('id',$varg) ? $varg['name'] : $varg['id'];
	$opt_val_fld=!array_key_exists('opt_val_fld',$varg) ? "id" : $varg['opt_val_fld'];
	$opt_txt_fld=!array_key_exists('opt_txt_fld',$varg) ? "region_name" : $varg['opt_txt_fld']; 
	
	$var.='<select name="'.$varg['name'].'" id="'.$varg['id'].'" '.$varg['format'].'>';
	if($varg['default_text']!="")
	{
		$var.='<option value="" selected="selected">'.$varg['default_text'].'</option>';
	}	
	$contry_res=$CI->db->query("SELECT * FROM wl_state WHERE country_id='".$varg['country_id']."' ORDER BY region_name ASC")->result_array();
	foreach($contry_res as $key=>$val)
	{		
		if(is_array($varg['current_selected_val']))
		{
			$select_element=in_array($val[$opt_val_fld],$varg['current_selected_val']) ? "selected" : "";
		}else
		{
			$select_element=( $varg['current_selected_val']==$val[$opt_val_fld] ) ? "selected" : "";
			if(is_string($varg['current_selected_val'])){ 
				$select_element=( $varg['current_selected_val']==$val[$opt_txt_fld] ) ? "selected" : "";
			}
		}		
		$var.='<option value="'.$val[$opt_val_fld].'" '.$select_element.'>'.ucfirst($val[$opt_txt_fld]).'</option>';
	}
	$var.='</select>';
	return $var;
}

function CitySelectBoxDropdown($varg=array())
{
	//trace($varg);exit;	
	$CI = CI();	
	$var="";
	
	/**********************************************************
	default_text 		=>Default Option Text
	name 		=> 			Dropdn name
	id 		=> 			Dropdn id (default to name)
	format      		=>	all extra attributes for the dpdn(style,class,event...)
	opt_val_fld     =>      DpDn option value field to be fetched from database
	opt_txt_fld     =>      DpDn option text field to be fetched from database
	
	***********************************************************/		
	$varg['default_text']=!array_key_exists('default_text',$varg) ? "Select City" : $varg['default_text'];
	$varg['id']=!array_key_exists('id',$varg) ? $varg['name'] : $varg['id'];
	$opt_val_fld=!array_key_exists('opt_val_fld',$varg) ? "id" : $varg['opt_val_fld'];
	$opt_txt_fld=!array_key_exists('opt_txt_fld',$varg) ? "city_name" : $varg['opt_txt_fld']; 
	
	$var.='<select name="'.$varg['name'].'" id="'.$varg['id'].'" '.$varg['format'].'>';
	if($varg['default_text']!="")
	{
		$var.='<option value="" selected="selected">'.$varg['default_text'].'</option>';
	}	
	$contry_res=$CI->db->query("SELECT * FROM wl_city WHERE region_id='".$varg['state_id']."' AND status='1' ORDER BY city_name ASC")->result_array();
	foreach($contry_res as $key=>$val)
	{		
		if(is_array($varg['current_selected_val']))
		{
			$select_element=in_array($val[$opt_val_fld],$varg['current_selected_val']) ? "selected" : "";
		}else
		{
			$select_element=( $varg['current_selected_val']==$val[$opt_val_fld] ) ? "selected" : "";
			if(is_string($varg['current_selected_val'])){
				$select_element=( $varg['current_selected_val']==$val[$opt_txt_fld] ) ? "selected" : "";
			}
		}		
		$var.='<option value="'.$val[$opt_val_fld].'" '.$select_element.'>'.ucfirst($val[$opt_txt_fld]).'</option>';
	}
	$var.='</select>';
	return $var;
}

function CitySelectBox($varg=array())
{
	//trace($varg);exit;	
	$CI = CI();	
	$var="";
	
	/**********************************************************
	default_text 		=>Default Option Text
	name 		=> 			Dropdn name
	id 		=> 			Dropdn id (default to name)
	format      		=>	all extra attributes for the dpdn(style,class,event...)
	opt_val_fld     =>      DpDn option value field to be fetched from database
	opt_txt_fld     =>      DpDn option text field to be fetched from database
	
	***********************************************************/		
	$varg['default_text']=!array_key_exists('default_text',$varg) ? "Select City" : $varg['default_text'];
	$varg['id']=!array_key_exists('id',$varg) ? $varg['name'] : $varg['id'];
	$opt_val_fld=!array_key_exists('opt_val_fld',$varg) ? "id" : $varg['opt_val_fld'];
	$opt_txt_fld=!array_key_exists('opt_txt_fld',$varg) ? "city_name" : $varg['opt_txt_fld']; 
	
	$var.='<select name="'.$varg['name'].'" id="'.$varg['id'].'" '.$varg['format'].' >';
	if($varg['default_text']!="")
	{
		$var.='<option value="" selected="selected">'.$varg['default_text'].'</option>';
	}	
	$contry_res=$CI->db->query("SELECT * FROM wl_city WHERE region_id='".$varg['state_id']."' AND status='1' ORDER BY city_name ASC")->result_array();
	foreach($contry_res as $key=>$val)
	{		
		if(is_array($varg['current_selected_val']))
		{
			$select_element=in_array($val[$opt_val_fld],$varg['current_selected_val']) ? "selected" : "";
		}else
		{
			$select_element=( $varg['current_selected_val']==$val[$opt_val_fld] ) ? "selected" : "";
			if(is_string($varg['current_selected_val'])){
				$select_element=( $varg['current_selected_val']==$val[$opt_txt_fld] ) ? "selected" : "";
			}
		}		
		$var.='<option value="'.$val[$opt_val_fld].'" '.$select_element.'>'.ucfirst($val[$opt_txt_fld]).'</option>';
	}
	$var.='</select>';
	return $var;
}

if ( ! function_exists('get_country_name')){
	
	function get_country_name($countryId)
	{
		$CI = CI();	
		
		if( $countryId > 0)
		{ 
			$res =  $CI->db->get_where("wl_countries",array('country_id'=>$countryId))->row();
			if( is_object($res) )
			{
				return $res->name;
			}
		}
	}
}

if ( ! function_exists('get_country_id')){
	
	function get_country_id($cname)
	{ 
		$CI = CI();	
		
		if( $cname !="")
		{ 
			$res =  $CI->db->get_where("wl_countries",array('name'=>$cname))->row();			
			if( is_object($res) )
			{
				return $res->country_id;
			}
		}
	}
}

if ( ! function_exists('get_state_name')){
	
	function get_state_name($stateId)
	{
		$CI = CI();	
		
		if( $stateId > 0)
		{ 
			$res =  $CI->db->get_where("wl_state",array('id'=>$stateId))->row();
			if( is_object($res) )
			{
				return $res->region_name;
			}
		}
	}
}

if ( ! function_exists('get_state_id')){
	
	function get_state_id($sname)
	{
		$CI = CI();	
		
		if( $sname !="")
		{ 
			$res =  $CI->db->get_where("wl_state",array('region_name'=>$sname))->row();
			if( is_object($res) )
			{
				return $res->id;
			}
		}
	}
}

if ( ! function_exists('get_city_name')){
	
	function get_city_name($cityId)
	{
		$CI = CI();	
		
		if( $cityId > 0)
		{ 
			$res =  $CI->db->get_where("wl_city",array('id'=>$cityId))->row();
			if( is_object($res) )
			{
				return $res->city_name;
			}
		}
	}
}


if ( ! function_exists('get_total_shipping_charge')){
	
	function get_total_shipping_charge($country){
		$CI = CI();	
		$total_shipping_weight=$CI->session->userdata('total_shipping_weight');	
		if( !empty($country) && !empty($total_shipping_weight)){			
				
			$res=$CI->db->query("SELECT shipment_rate FROM wl_shipping WHERE shipping_country ='".$country."' AND weight_from <='".$total_shipping_weight."'  AND weight_to >='".$total_shipping_weight."'  ")->result_array();	
								
			if( is_array($res) && !empty($res)){					
				return $res[0]['shipment_rate'];
			}else{
				return 0;	
			}
		}
	}
}


if ( ! function_exists('has_child_faq'))
{
	function has_child_faq($catid,$condtion="AND status='1'")
	{
		  $ci = CI();
		  $sql="SELECT faq_category_id FROM wl_faq_category WHERE parent_id=$catid $condtion ";
		  $query = $ci->db->query($sql);
		  $num_rows     =  $query->num_rows();
		  return $num_rows >= 1 ? TRUE : FALSE;
	}
}


if ( ! function_exists('get_nested_dropdown_menu_faq'))
{
	function get_nested_dropdown_menu_faq($parent,$selectId="",$pad="|__")
	{

		 $ci = CI();
		 $selId =( $selectId!="" ) ? $selectId : "";
		 $var="";
		 $sql="SELECT * FROM wl_faq_category WHERE parent_id=$parent AND status='1' ORDER BY sort_order ASC ";
		 $query=$ci->db->query($sql);
		 $num_rows     =  $query->num_rows();

		  if ($num_rows > 0  )
		  {

		    foreach( $query->result_array() as $row )
		    {
			   $category_name=ucfirst(strtolower($row['faq_category_name']));

			   if ( has_child_faq($row['faq_category_id']) )
			   {

				    $var .= '<optgroup label="'.$pad.'&nbsp;'.$category_name.'" >'.$category_name.'</optgroup>';
					$var .= get_nested_dropdown_menu_faq($row['faq_category_id'],$selId,'&nbsp;&nbsp;&nbsp;'.$pad);

				  }else
				  {

					 $sel=( $selectId==$row['faq_category_id'] ) ? "selected='selected'" : "";
					 $var .= '<option value="'.$row['faq_category_id'].'" '.$sel.'>'.$pad.$category_name.'  </option>';

				  }
			   }
		   }

      return $var;
   }

}