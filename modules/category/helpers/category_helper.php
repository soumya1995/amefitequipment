<?php
if ( ! function_exists('has_child'))
{
	function has_child($catid,$condtion="AND status='1'")
	{
		  $ci = CI();
		  $sql="SELECT category_id FROM wl_categories WHERE parent_id=$catid $condtion ";
		  $query = $ci->db->query($sql);
		  $num_rows     =  $query->num_rows();
		  return $num_rows >= 1 ? TRUE : FALSE;
	}
}

if ( ! function_exists('get_child_categories'))
{
   function get_child_categories($parent='0',$condtion="AND status='1' ", $fields='SQL_CALC_FOUND_ROWS*')
   {
	     $parent = (int) $parent;
	     $ci     = CI();
         $output        = array();
		 $sql           = "SELECT  $fields FROM wl_categories WHERE parent_id=$parent $condtion  ";
		 $query         = $ci->db->query($sql);
         $num_rows      =  $query->num_rows();

        if ( $num_rows > 0) {

            foreach( $query->result_array() as $row )
			{

			    $output[$row['category_id']]['parent'] = $row;
				$output[$row['category_id']]['child'] = array();

                if ( has_child($row['category_id'] ))
				{
                    $output[$row['category_id']]['child'] = get_child_categories($row['category_id'], $condtion, $fields);

                }

            }
        }

        return $output;
    }

}

/*
$res = get_parent_categories('6','','category_id,parent_id,category_name');

*/

if ( ! function_exists('get_parent_categories'))
{

   function get_parent_categories($category_id,$condtion="AND status='1'", $fields='*')
   {
         $category_id   = (int) $category_id;
	     $ci            = CI();
         $output        = array();
		 $sql           = "SELECT $fields FROM wl_categories WHERE category_id=$category_id $condtion  ";
		 $query         = $ci->db->query($sql);
         $num_rows      =  $query->num_rows();

        if ( $num_rows > 0)
		{

		    foreach( $query->result_array() as $row )
			{
			     $parent_id =  $row['parent_id'];
			     $output[$row['category_id']] = $row;

				 while( $parent_id>0 )
				 {
					 $sql           = "SELECT $fields FROM wl_categories WHERE category_id=$parent_id $condtion  ";
					 $query         = $ci->db->query($sql);
					 $num_rows      =  $query->num_rows();

					 if ( $num_rows > 0)
					 {

						foreach( $query->result_array() as $row )
						{
							$parent_id = $row['parent_id'];
							$output[$row['category_id']] = $row;
						}
					 }
					 else
					 {
						$parent_id = 0;
					 }
				 }

			}

		}

	    return $output;

   }


}


if ( ! function_exists('get_nested_dropdown_menu'))
{
	function get_nested_dropdown_menu($parent,$selectId="",$pad="|__")
	{

		 $ci = CI();
		 $selId =( $selectId!="" ) ? $selectId : "";
		 $var="";
		 $sql="SELECT * FROM wl_categories WHERE parent_id=$parent AND status='1' ORDER BY sort_order ASC ";
		 $query=$ci->db->query($sql);
		 $num_rows     =  $query->num_rows();

		  if ($num_rows > 0  )
		  {

		    foreach( $query->result_array() as $row )
		    {
			   $category_name=ucfirst(strtolower($row['category_name']));

			   if ( has_child($row['category_id']) )
			   {

				    $var .= '<optgroup label="'.$pad.'&nbsp;'.$category_name.'" >'.$category_name.'</optgroup>';
					$var .= get_nested_dropdown_menu($row['category_id'],$selId,'&nbsp;&nbsp;&nbsp;'.$pad);

				  }else
				  {

					 $sel=( $selectId==$row['category_id'] ) ? "selected='selected'" : "";
					 $var .= '<option value="'.$row['category_id'].'" '.$sel.'>'.$pad.$category_name.'  </option>';

				  }
			   }
		   }

      return $var;
   }

}

if ( ! function_exists('get_root_level_categories_dropdown'))
{
	function get_root_level_categories_dropdown($parent,$selectId="")
	{

		 $ci = CI();
		 $selId =( $selectId!="" ) ? $selectId : "";
		 $var="";
		 $sql="SELECT * FROM wl_categories WHERE parent_id=$parent AND status='1' ORDER BY sort_order ASC ";
		 $query=$ci->db->query($sql);
		 $num_rows     =  $query->num_rows();

		  if ($num_rows > 0  )
		  {

		    foreach( $query->result_array() as $row )
		    {
			   $category_name=ucwords(strtolower($row['category_name']));
			   $sel=( $selectId==$row['category_id'] ) ? "selected='selected'" : "";
			   $var .= '<option value="'.$row['category_id'].'" '.$sel.'>'.$category_name.'  </option>';

			   }
		   }

      return $var;
   }

}

if ( ! function_exists('get_seller_dropdown'))
{
	function get_seller_dropdown($selectId="")
	{

		 $ci = CI();
		 $selId =( $selectId!="" ) ? $selectId : "";
		 $var="";
		 $sql="SELECT customers_id, CONCAT(first_name,' ',last_name) as seller_name FROM  wl_customers WHERE customer_type='1' AND status='1' AND is_verified='1' ORDER BY seller_name ASC ";
		 $query=$ci->db->query($sql);
		 $num_rows     =  $query->num_rows();

		  if ($num_rows > 0  )
		  {
		    foreach( $query->result_array() as $row )
		    {
			   $seller_name=ucwords(strtolower($row['seller_name']));
			   $sel=( $selectId==$row['customers_id'] ) ? "selected='selected'" : "";
			   $var .= '<option value="'.$row['customers_id'].'" '.$sel.'>'.$seller_name.'  </option>';
			   }
		   }
      return $var;
   }

}

/*

$cond = "AND parent_id =".$pageVal['category_id'];
echo count_category($cond);

*/

if ( ! function_exists('count_category'))
{
	function count_category($condtion='')
	{
		 $ci = CI();
		 $condtion = "status !='2' ".$condtion;
		 $sql="SELECT COUNT(category_id)  AS total_subcategories FROM wl_categories WHERE $condtion ";
		 $query=$ci->db->query($sql)->row_array();
		 return  $query['total_subcategories'];

	}
}


if ( ! function_exists('count_products'))
{
	function count_products($condtion='')
	{
		 $ci = CI();
		 $condtion = "status !='2' ".$condtion;
		 $sql="SELECT COUNT(products_id)  AS total_product FROM wl_products WHERE $condtion ";
		 $query=$ci->db->query($sql)->row_array();
		 return  $query['total_product'];

	}
}

if ( ! function_exists('category_breadcrumb'))
{
	function category_breadcrumb($catid,$segment='')
	{
		$link_cat=array();
		$ci = CI();
		$sql="SELECT category_name,category_id,parent_id,friendly_url
		FROM wl_categories WHERE category_id='$catid' AND status='1' ";
		$query=$ci->db->query($sql);
		$num_rows     =  $query->num_rows();
		$segment      = $ci->uri->rsegment($segment,0);

		if ($num_rows > 0)
		{
			foreach( $query->result_array() as $row )
			{
				if ( has_child( $row['parent_id'] ) )
				{
					$condtion_product   =  "AND category_id='".$row['category_id']."'";
					$product_count      = count_products($condtion_product);

					if($product_count>0)
					{
						$link_url = base_url()."".$row['friendly_url'];
					}else
					{
						$link_url = base_url()."".$row['friendly_url'];
					}

					if( $segment!='' && ( $row['category_id']==$segment ) )
					{
						$link_cat[]='<li  class="active">'.$row['category_name'].'</li>';
					}else
					{
						$link_cat[]='<li><a href="'.$link_url.'">'.$row['category_name'].'</a></li>';
					}
					$link_cat[] = category_breadcrumb($row['parent_id'],$segment);
				}else
				{
					$link_url = base_url()."".$row['friendly_url'];
					$link_cat[]='<li><a href="'.$link_url.'">'.$row['category_name'].'</a></li>';
				}
			}
		}else
		{
			$link_url = base_url()."category";
			$link_cat[]='<li  class="active"><a href="'.$link_url.'">Categories</a></li>';
		}

		$link_cat = array_reverse($link_cat);
		$category_links=implode($link_cat);
		return $category_links;

	}

}

if ( ! function_exists('category_breadcrumbs'))
{
	function category_breadcrumbs($catid,$segment='',$heading='')
	{
		$category_links=category_breadcrumb($catid,$segment);
		$navigation_content='
		<ul class="breadcrumb">
        <li><a href="'.base_url().'">Home</a></li>
		 '.$category_links;
						if($heading!=''){
						$navigation_content.='
						<li>'.$heading.'</li>';
						}
			 $navigation_content.='
			 </ul>';			
		
		return $navigation_content;
	}
}

if ( ! function_exists('get_category_name'))
{
		function get_category_name($catid) {
		$ci = CI();
		$sql="SELECT category_name FROM wl_categories WHERE category_id='$catid' AND status='1' ";
		$query=$ci->db->query($sql);

		$num_rows     =  $query->num_rows();
			if($num_rows>0)
			{
				return $query->row_array();

			}

		}
}

if (!function_exists('get_category_chain')) {

	function get_category_chain($catid) {
		$CI = & get_instance();
		$array = '';
		$var = '';
		$sql1 = $CI->db->query("select category_id,parent_id,category_name from wl_categories where category_id='$catid' and status='1'");
		$res = $sql1->row_array();
		$flag = 0;
		$catparent = $catid;
		while ($flag != 1) {

			$sql2 = $CI->db->query("select category_id,parent_id,category_name from wl_categories where category_id='$catparent' and status='1'");
			$record = $sql2->row_array();

			if ($record['parent_id'] != 0) {
				$catparent = $record['parent_id'];
				$array.=$record['category_name'] . "~";
			} else {
				if ($record['category_id'] != "") {
					$array.=$record['category_name'] . "~";
				}
				$flag = 1;
			}
		}
		$arr1 = explode("~", $array);

		$arr = array_reverse($arr1);

		for ($i = 0; $i < count($arr); $i++) {
			if ($arr[$i] != '') {
				$var .=$arr[$i] . "&raquo;";
			}
		}

		return $var;
	}

} 


function buildcategory($array,$parent)
{
	$html="";
    $html.='<ul>'; 
	$incr=1;
	$li_incr=1;                
    foreach($array as $category)
    {
		$class = ($incr==1) ? "minus": "minus";

        if($category['parent'] == $parent)
        {
             if($category['parent'] == '0')
             {
				 $q = CI()->db->query("SELECT category_id FROM wl_categories where parent_id = $category[id] ");
				 $num = $q->num_rows();
				 $result = $q->result_array();
			 
				 if($num >0 )
				 {
					 
						$html.='<li class="has-sub"> <a title="'.$category['name'].'" href="'.site_url($category['friendly_url']).'">'.char_limiter($category['name'],25).'</a>' . "\n\t\t\t\t";

        						$html .= buildcategory($array,$category['id']);       
      						$html.='</li>';
				 
				 }else
				 {
					 $html.='<li><a title="'.$category['name'].'" href="'.site_url($category['friendly_url']).'">'.char_limiter($category['name'],25).'</a> </li>' . "\n\t\t\t\t";

				 }
				 
              }
              else
              {
				 $q = CI()->db->query("SELECT category_id FROM wl_categories where parent_id = $category[id] ");
				 $num = $q->num_rows();
				 $result = $q->result_array();
				 
				 if($num >0 )
				 {	
						$html.='<li class="has-sub"> <a title="'.$category['name'].'" href="'.site_url($category['friendly_url']).'">'.char_limiter($category['name'],25).'</a>' . "\n\t\t\t\t";
      						//$html.='<ul>';
        						$html .= buildcategory($array,$category['id']);       
      						$html.='</li>';
				 			
				 }else
				 {
					 $html.='<li><a title="'.$category['name'].'" href="'.site_url($category['friendly_url']).'">'.char_limiter($category['name'],25).'</a> </li>' . "\n\t\t\t\t";
				 }
				
               } 
			                          
          }
		  $li_incr++;
    $incr++;
	
	}
	$html.='</ul>';
    return $html;
}


if ( ! function_exists('get_table_content'))
{
	function get_table_content($fld=FALSE,$tablename,$Condwherw=FALSE)
	{
		$CI = CI();	
		$fld=($fld!='')?$fld:"*";	
		$Condwherw=($Condwherw!='')?$Condwherw:" 1 ";
		
		$selquery="SELECT $fld
		           FROM $tablename
				   WHERE $Condwherw";
		$query=$CI->db->query($selquery);
		
		if($query->num_rows() > 0){
			
		  	return $query->result_array();
			
		}
	}
}