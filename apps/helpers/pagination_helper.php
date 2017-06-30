<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
  * The Pagination helper cuts out some of the bumf of normal pagination
  * @author		Philip Sturgeon
  * @filename	pagination_helper.php
  * @title		Pagination Helper
  * @version	1.0
 **/

function front_pagination($base_uri, $total_rows, $record_per = NULL, $uri_segment)
{		
	$ci = CI();
	$ci->load->library('Front_pagination');	
	/* Initialize pagination */
		
	$config['full_tag_open']        = '<li>';  
	$config['full_tag_close']        = '</li>';
	$config['per_page']			 = $record_per === NULL ? $ci->config->item('per_page') : $record_per;
	$config['num_links']         = 2;	
	$config['next_link']         = '&gt;&gt;';
	$config['prev_link']         = '&lt;&lt;';
	$config['base_url']          = base_url().$base_uri;
	 	  
    $config['total_rows']			= $total_rows; 
    $config['uri_segment']			= $uri_segment;
	$config['page_query_string']	= FALSE;
	$config['next_tag_open']		= '';
	$config['next_tag_close']		= '';	
	$config['prev_tag_open']		= '';
	$config['prev_tag_close']		= '';	
	$config['num_tag_open']		= '';
	$config['num_tag_close']		= '';
	$config['cur_tag_open']	= '<a href="javascript:void(0);" class="active">';
	$config['cur_tag_close']	    = '</a>';
	$config['additional_param']     = 'serialize_form()';
	$config['div']                  = '#my_data';
	$config['display_pages'] 		= FALSE;
	$config['use_page_numbers']		=	FALSE;
	$ci->front_pagination->initialize($config);
	$data = $ci->front_pagination->create_links();
	return $data;	
	  
}

if(!function_exists('more_paging'))
{
	function more_paging($base_uri, $total_rows, $record_per = NULL,$next=0,$options=array())
	{
		
		$text  		    	=   array_key_exists('text',$options)? $options['text'] : 'Show More &raquo;';
		$start_tag  		=   array_key_exists('start_tag',$options)? $options['start_tag'] : '';
		$end_tag  			=   array_key_exists('end_tag',$options)? $options['end_tag'] : '';
		$more_container     =   array_key_exists('more_container',$options)? $options['more_container'] : 'more_data';
		$form_id  	    	=   array_key_exists('form_id',$options)? $options['form_id'] : '0';
	
		if($record_per!=NULL)
		{
			
			$base_uri=base_url().$base_uri;
			 
			if($total_rows>$record_per && $next<$total_rows)
			{
				$more_link ='<p class="b mores ar black u"><a href="javascript:void(0)" id="more_loader_link'.$more_container.'" onclick="load_more(\''.$base_uri.'\',\''.$more_container.'\',\''.$form_id.'\');">';
				$more_link.=$start_tag;
				$more_link.=$text;
				$more_link.=$end_tag;
				$more_link.='</a></p>';
				
				return $more_link;
			}
			if($total_rows>$record_per && $next>=$total_rows)
			{
				$more_link=$start_tag;
				$more_link.='<div style="margin-top:8px; text-align:center;">No more product(s) to display...</div>';
				$more_link.=$end_tag;
				
				return $more_link;
			}
		}
		
	}
	
}


if ( ! function_exists('pagination_refresh'))
{
	function pagination_refresh($base_uri, $total_rows, $record_per, $uri_segment)
	{
			$ci = CI();	
			$ci->load->library('pagination');			
	        $config['full_tag_open']        = '';  
	        $config['full_tag_close']        = '';
			$config['per_page']			= $record_per;
			$config['num_links']        = 2;	
			$config['next_link']        = '&gt;&gt;';
			$config['prev_link']        = '&lt;&lt;';	 	  
			$config['total_rows']		= $total_rows;
		    $config['uri_segment']		= $uri_segment;		
			$config['next_tag_open']		= '';
			$config['next_tag_close']		= '';	
			$config['prev_tag_open']		= '';
			$config['prev_tag_close']		= '';	
			$config['num_tag_open']		= '';
			$config['num_tag_close']		= '';
			$config['cur_tag_open']	= '<a href="#" class="act">';
		    $config['cur_tag_close']	    = '</a>';
			$config['page_query_string']	= TRUE;
			$config['display_pages']	= TRUE;
			$config['use_page_numbers']=TRUE;
			$config['base_url']             = $base_uri;
			$ci->pagination->initialize($config);
			$data = $ci->pagination->create_links();		
		 
		   return $data;	
		  
	}
}


function front_record_per_page($per_page_id,$name='per_page')
{	
   $ci = CI();
   $post_per_page =  $ci->input->get_post($name);

?>
     <select  name="<?php echo $name;?>" id="<?php echo $per_page_id;?>" class="p3 radius-3">
      <option value="">Show Results :</option>
    <?php
    foreach($ci->config->item('frontPageOpt') as $val)
    {
    ?>
    <option value="<?php echo $val;?>" <?php echo $post_per_page==$val ? "selected" : "";?>>
	  <?php echo $val;?> Records</option>
    <?php
    }
    ?>
</select>

<?php
}
?>