<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');

/**
 * CodeIgniter URL Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Philip Sturgeon
 */

// ------------------------------------------------------------------------

/**
 * Create URL Title - modified version
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with either a dash
 * or an underscore as the word separator.
 * 
 * Added support for Cyrillic characters.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator: dash, or underscore
 * @return	string
 */
if ( ! function_exists('url_title'))
{
	function url_title($str, $separator = 'dash', $lowercase = TRUE)
    {
        $CI =& get_instance();
        
        $foreign_characters = array(
            '/Ã¤|Ã¦|Ç½/' => 'ae',
            '/Ã¶|Å“/' => 'oe',
            '/Ã¼/' => 'ue',
            '/Ã„/' => 'Ae',
            '/Ãœ/' => 'Ue',
            '/Ã–/' => 'Oe',
            '/Ã€|Ã�|Ã‚|Ãƒ|Ã„|Ã…|Çº|Ä€|Ä‚|Ä„|Ç�|Ð�/' => 'A',
            '/Ã |Ã¡|Ã¢|Ã£|Ã¥|Ç»|Ä�|Äƒ|Ä…|ÇŽ|Âª|Ð°/' => 'a',
            '/Ð‘/' => 'B',
            '/Ð±/' => 'b',
            '/Ã‡|Ä†|Äˆ|ÄŠ|ÄŒ|Ð¦/' => 'C',
            '/Ã§|Ä‡|Ä‰|Ä‹|Ä�|Ñ†/' => 'c',
            '/Ã�|ÄŽ|Ä�|Ð”/' => 'D',
            '/Ã°|Ä�|Ä‘|Ð´/' => 'd',
            '/Ãˆ|Ã‰|ÃŠ|Ã‹|Ä’|Ä”|Ä–|Ä˜|Äš|Ð•|Ð�|Ð­/' => 'E',
            '/Ã¨|Ã©|Ãª|Ã«|Ä“|Ä•|Ä—|Ä™|Ä›|Ðµ|Ñ‘|Ñ�/' => 'e',
            '/Ð¤/' => 'F',
            '/Ñ„/' => 'f',
            '/Äœ|Äž|Ä |Ä¢|Ð“/' => 'G',
            '/Ä�|ÄŸ|Ä¡|Ä£|Ð³/' => 'g',
            '/Ä¤|Ä¦|Ð¥/' => 'H',
            '/Ä¥|Ä§|Ñ…/' => 'h',
            '/ÃŒ|Ã�|ÃŽ|Ã�|Ä¨|Äª|Ä¬|Ç�|Ä®|Ä°|Ð˜/' => 'I',
            '/Ã¬|Ã­|Ã®|Ã¯|Ä©|Ä«|Ä­|Ç�|Ä¯|Ä±|Ð¸/' => 'i',
            '/Ä´|Ð™/' => 'J',
            '/Äµ|Ð¹/' => 'j',
            '/Ä¶|Ðš/' => 'K',
            '/Ä·|Ðº/' => 'k',
            '/Ä¹|Ä»|Ä½|Ä¿|Å�|Ð›/' => 'L',
            '/Äº|Ä¼|Ä¾|Å€|Å‚|Ð»/' => 'l',
            '/Ðœ/' => 'M',
            '/Ð¼/' => 'm',
            '/Ã‘|Åƒ|Å…|Å‡|Ð�/' => 'N',
            '/Ã±|Å„|Å†|Åˆ|Å‰|Ð½/' => 'n',
            '/Ã’|Ã“|Ã”|Ã•|ÅŒ|ÅŽ|Ç‘|Å�|Æ |Ã˜|Ç¾|Ðž/' => 'O',
            '/Ã²|Ã³|Ã´|Ãµ|Å�|Å�|Ç’|Å‘|Æ¡|Ã¸|Ç¿|Âº|Ð¾/' => 'o',
            '/ÐŸ/' => 'P',
            '/Ð¿/' => 'p',
            '/Å”|Å–|Å˜|Ð /' => 'R',
            '/Å•|Å—|Å™|Ñ€/' => 'r',
            '/Åš|Åœ|Åž|Å |Ð¡/' => 'S',
            '/Å›|Å�|ÅŸ|Å¡|Å¿|Ñ�/' => 's',
            '/Å¢|Å¤|Å¦|Ð¢/' => 'T',
            '/Å£|Å¥|Å§|Ñ‚/' => 't',
            '/Ã™|Ãš|Ã›|Å¨|Åª|Å¬|Å®|Å°|Å²|Æ¯|Ç“|Ç•|Ç—|Ç™|Ç›|Ð£/' => 'U',
            '/Ã¹|Ãº|Ã»|Å©|Å«|Å­|Å¯|Å±|Å³|Æ°|Ç”|Ç–|Ç˜|Çš|Çœ|Ñƒ/' => 'u',
            '/Ð’/' => 'V',
            '/Ð²/' => 'v',
            '/Ã�|Å¸|Å¶|Ð«/' => 'Y',
            '/Ã½|Ã¿|Å·|Ñ‹/' => 'y',
            '/Å´/' => 'W',
            '/Åµ/' => 'w',
            '/Å¹|Å»|Å½|Ð—/' => 'Z',
            '/Åº|Å¼|Å¾|Ð·/' => 'z',
            '/Ã†|Ç¼/' => 'AE',
            '/ÃŸ/'=> 'ss',
            '/Ä²/' => 'IJ',
            '/Ä³/' => 'ij',
            '/Å’/' => 'OE',
            '/Æ’/' => 'f',
            '/Ð§/' => 'Ch',
            '/Ñ‡/' => 'ch',
            '/Ð®/' => 'Ju',
            '/ÑŽ/' => 'ju',
            '/Ð¯/' => 'Ja',
            '/Ñ�/' => 'ja',
            '/Ð¨/' => 'Sh',
            '/Ñˆ/' => 'sh',
            '/Ð©/' => 'Shch',
            '/Ñ‰/' => 'shch',
            '/Ð–/' => 'Zh',
            '/Ð¶/' => 'zh',
        );

        $str = preg_replace(array_keys($foreign_characters), array_values($foreign_characters), $str);
        
        $replace = ($separator == 'dash') ? '-' : '_';
        
        $trans = array(
            '&\#\d+?;'                => '',
            '&\S+?;'                => '',
            '\s+'                    => $replace,
            '[^a-z0-9\-\._]' => '',
            $replace.'+'            => $replace,
            $replace.'$'            => $replace,
            '^'.$replace            => $replace,
            '\.+$'                    => ''
        );

        $str = strip_tags($str);

        foreach ($trans as $key => $val)
        {
            $str = preg_replace("#".$key."#i", $val, $str);
        }
        
        if ($lowercase === TRUE)
        {
            if( function_exists('mb_convert_case') )
            {
                $str = mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
            }
            else
            {
                $str = strtolower($str);
            }
        }

        $str = preg_replace('#[^'.$CI->config->item('permitted_uri_chars').']#i', '', $str);        
        return trim(stripslashes($str));
     }
}


 function switch_account($type)
 {
		switch ($type )
		{
		    case 1: 
			
		      redirect('members', '');
			  
			break;
			
			default:
			
            redirect('members', '');
			
		}
			  
 }	


// ------------------------------------------------------------------------


/**
 * Theme URL
 *
 * Returns the Ionize current theme URL
 *
 * @access	public
 * @return	string
 */
 
if ( ! function_exists('resource_url'))
{
	function resource_url()
	{
		return base_url()."assets/designer/resources/";
	}
}
 
if ( ! function_exists('theme_url'))
{
	function theme_url()
	{
		return base_url()."assets/designer/themes/default/";
	}
}

if ( ! function_exists('img_url'))
{
	function img_url()
	{
		return base_url()."uploaded_files/";
	}
}

if ( ! function_exists('thumb_cache_url'))
{
	function thumb_cache_url()
	{
		return base_url()."uploaded_files/thumb_cache/";
	}
	
}

if ( ! function_exists('clear_search'))
{
  function clear_search ()
  {
	  
	   $ci            =  &get_instance(); 
	   $pagesz        = $ci->config->item('per_page');
	   $clear_search  = $ci->input->get();
	   $clear_search  = @array_filter( $clear_search);
	   $clear_search  = @array_filter( $clear_search);	
	   
	   if( is_array($clear_search) && array_key_exists('city',$clear_search) && ($clear_search['city']=='Search City'))
	   {
		   unset($clear_search['city']);
	   }
	   
		if( is_array($clear_search) && array_key_exists('plan',$clear_search) && ($clear_search['plan']=='all'))
	   {
		   unset($clear_search['plan']);
	   }
	   
	   if( is_array($clear_search) && array_key_exists('pagesize',$clear_search) && ($clear_search['pagesize']==$pagesz))
	   {
		   unset($clear_search['pagesize']);
	   }
	   
		unset($clear_search['search_x']);
		unset($clear_search['search_y']);
		unset($clear_search['input_x']);
		unset($clear_search['input_y']);
	   
	   
	   
	  ?>
	
					  <?php if(is_array( $clear_search) && !empty(  $clear_search)) 
					  {
						  ?>
						
						  <div class="paging_cntnr mt10" style="width:650px; margin-bottom:5px;">
							  <table width="80%" border="0" cellspacing="0" cellpadding="0">
							 <tr>
							 <td  class="tahoma b ft-10 black"> Clear Search : <td>
							 <td> 
						  <?php 
						  foreach( $clear_search as $k=>$v)
						  {
							  if(trim($k)!='')
							  {
							  ?>
							  
							<p class="fl ml30">                 
							<?php echo ucfirst($k);?>  <a href="<?php echo query_string('',array($v=>$k));?>"><img src="<?php echo base_url()?>assets/clear_search.jpg" class="v-mid mb2"  /></a> </p>                    
						
						
						<?php
							  }							
						  }
					   ?>
					   <p class="fl ml40">All <a href="<?php echo current_url();?>"><img src="<?php echo base_url()?>assets/clear_search.jpg"  /></a>  </p>
					   <?php
					   }
					   ?>
					  </td>
						</tr>
					</table>
					  </div>
					
  <?php
  } 
}

if ( ! function_exists('navigation_breadcrumb')){
	function navigation_breadcrumb($page_title, $crumbs=""){
		?>
        <ul class="breadcrumb">
        <li><a href="<?php echo base_url();?>">Home</a></li>
		<?php 
            if(@is_array($crumbs)){
                foreach($crumbs as $key=>$val){
                        echo '<li><a href="'.$val.'">'.$key.'</a></li>';
                }
            }else if($crumbs!=""){
                echo '<li><a href="categories.htm">'.$crumbs.'</a></li>';
            }
            echo '<li  class="active">'.$page_title.'</a>';
        ?>
        </ul>              
		<?php
	}
}

/**
 * Header Redirect
 *
 * Header redirect in two flavors + 1 js flavor
 * For very fine grained control over headers, you could use the Output
 * Library's set_header() function.
 *
 * @access	public
 * @param	string	the URL
 * @param	string	the method: location or redirect or js
 * @return	string
 */
if ( ! function_exists('redirect'))
{
	function redirect($uri = '', $method = 'location', $http_response_code = 302)
	{
		if ( ! preg_match('#^https?://#i', $uri))
		{
			$uri = site_url($uri);
		}

		switch($method)
		{
			case 'refresh'	: header("Refresh:0;url=".$uri);
			break;
			case 'js':
			?>
				<script type="text/javascript">
					top.location.href='<?php echo $uri;?>';
				</script>
			<?php
			break;
			default			: header("Location: ".$uri, TRUE, $http_response_code);
			break;
		}
		exit;
	}
}